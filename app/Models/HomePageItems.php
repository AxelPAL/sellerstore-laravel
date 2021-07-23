<?php

namespace App\Models;

use Cache;
use GuzzleHttp\Client;
use PHPHtmlParser\Dom;

class HomePageItems
{
    protected const HOME_ITEMS_CACHE_KEY = 'home_items';
    protected const POPULAR_CATEGORIES_CACHE_KEY = 'popular_categories';

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
        $queryParams = [
            'id'   => 0,
            'lang' => 'ru-RU',
            'curr' => 'RUR',
            'rnd'  => random_int(0, 10000),
        ];
        $id = 500;
        $items = [];
        while ($id > 0) {
            $id = $id === -1 ? 0 : $id;
            $queryParams['id'] = $id;
            $result = $this->client->get(env('PLATI_BASE_URL') . '/asp/items.asp', [
                'query' => $queryParams,
                'headers' => [
                    'User-Agent' => env('USER_AGENT_FOR_PLATI'),
                ]
            ]);
            $dom = new Dom();
            $content = $result->getBody()->getContents();
            preg_match('/((\d+)\|\d+\|)<div/i', $content, $matches);
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
                    'id'    => $itemId,
                    'name'  => $name,
                    'image' => "//graph.digiseller.ru/img.ashx?id_d=$itemId&w=120&crop=true",
                    'price' => (float)$price,
                ];
                $items[] = $item;
            }
            $id = $matches[2] ?? 0;
        }
        $this->cache::set(self::HOME_ITEMS_CACHE_KEY, $items, now()->addHours(23));
        return $items;

    }

    public function parsePopularCategories(): array
    {
        $self = $this;
        $categories = [];
        $result = $self->client->get('http://www.plati.com/api/top.ashx', [
            'headers' => [
                'User-Agent' => env('USER_AGENT_FOR_PLATI'),
            ]
        ]);
        $content = $result->getBody()->getContents();
        $xml = simplexml_load_string($content);
        foreach ($xml->section as $section) {
            $name = (string)$section->name;
            $id = (string)$section->attributes()->id;
            $categories[] = compact('id', 'name');
        }
        $this->cache::set(self::POPULAR_CATEGORIES_CACHE_KEY, $categories, now()->addHours(12));
        return $categories;
    }

    public function getPopularCategoriesFromCache(): array
    {
        return $this->cache::get(self::POPULAR_CATEGORIES_CACHE_KEY, []);
    }

    public function getHomeItemsFromCache(): array
    {
        return $this->cache::get(self::HOME_ITEMS_CACHE_KEY, []);
    }
}
