<?php

namespace App\models;

use Cache;
use GuzzleHttp\Client;
use PHPHtmlParser\Dom;
use SimpleXMLElement;

class HomePageItems
{
    public const PLATI_URL = 'http://plati.io';
    /**
     * @var Client
     */
    private $client;
    /**
     * @var Cache
     */
    private $cache;

    public function __construct(Client $client, Cache $cache)
    {

        $this->client = $client;
        $this->cache = $cache;
    }

    public function parseHomeItems(): array
    {
        $self = $this;
        $result = $this->cache::remember('home_items', now()->addHours(23), static function () use ($self) {
            $queryParams = [
                'id' => 0,
                'lang' => 'ru-RU',
                'curr' => 'RUR',
                'rnd' => random_int(0, 10000),
            ];
            $id = 500;
            $items = [];
            while ($id > 0) {
                $id = $id === -1 ? 0 : $id;
                $queryParams['id'] = $id;
                $result = $self->client->get(self::PLATI_URL . '/asp/items.asp', [
                    'query' => $queryParams
                ]);
                $dom = new Dom();
                $content = $result->getBody()->getContents();
                preg_match('/((\d+)\|\d+\|)<div>/i', $content, $matches);
                if (!empty($matches[1])) {
                    $content = str_replace($matches[1], '', $content);
                }
                $dom->load($content);
                $divs = $dom->find('div');
                foreach ($divs as $div) {
                    /** @var Dom\HtmlNode $link */
                    /** @var Dom $div */
                    $link = $div->getChildren()[0];
                    $tag = $link->getTag();
                    $linkInHref = $tag->getAttribute('href')['value'];
                    $itemId = (int)mb_substr($linkInHref, strrpos($linkInHref, '/') + 1);
                    $name = $link->getChildren()[1]->text;
                    $price = $link->getChildren()[2]->text;
                    $item = [
                        'id' => $itemId,
                        'name' => $name,
                        'image' => "//graph.digiseller.ru/img.ashx?id_d=$itemId&w=120&crop=true",
                        'price' => (float)$price,
                    ];
                    $items[] = $item;
                }
                $id = $matches[2] ?? 0;
            }
            return $items;
        });
        return $result;

    }

    public function getPopularCategories(): array
    {
        $self = $this;
        $categories = $this->cache::remember(
            'popular_categories',
            now()->addHours(12),
            static function () use ($self) {
                $categories = [];
                $result = $self->client->get('http://www.plati.com/api/top.ashx');
                $content = $result->getBody()->getContents();
                $xml = simplexml_load_string($content);
                foreach ($xml->section as $section) {
                    $name = (string)$section->name;
                    $id = (string)$section->attributes()->id;
                    $categories[] = compact('id', 'name');
                }
                return $categories;
            }
        );
        return $categories;
    }

    public function getSidebar(): array
    {
        $self = $this;
        $sidebar = $this->cache::remember(
            'sidebar',
            now()->addHours(12),
            static function () use ($self) {
                $sidebarData = [
                    'id_catalog' => 0,
                    'rows' => 500
                ];
                $xml = $self->prepareXml($sidebarData);
                $content = $self->getResponseFromPlati($xml, 'sections');
                return json_decode(json_encode((array)$content->folder), true);
            }
        );
        return $sidebar;

    }

    private function prepareXml(array $data): SimpleXMLElement
    {
        $xml = new SimpleXMLElement('<digiseller.request></digiseller.request>');
        $xml->addChild('guid_agent', 'C1127FCB0AD845F9A95E51A25973CA3D');
        foreach ($data as $key => $item) {
            $xml->addChild($key, $item);
        }
        return $xml;
    }

    private function getResponseFromPlati(SimpleXMLElement $xml, string $pageName): SimpleXMLElement
    {
        $result = $this->client->post(self::PLATI_URL . "/xml/$pageName.asp", [
            'body' => $xml->asXML(),
            'headers' => [
                'Content-Type' => 'text/xml'
            ]
        ]);
        return simplexml_load_string($result->getBody()->getContents());
    }
}
