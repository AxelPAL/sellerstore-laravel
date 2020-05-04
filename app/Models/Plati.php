<?php

namespace App\Models;

use Cache;
use GuzzleHttp\Client;
use SimpleXMLElement;
use Throwable;

class Plati
{
    public const DEFAULT_ROWS_COUNT  = 100;
    public const SEARCH_PAGE_SIZE    = 500;
    protected const DEFAULT_CURRENCY = 'RUR';
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

    public function getPlatiBaseUrl()
    {
        return env('PLATI_BASE_URL');
    }

    public function getSidebar(): array
    {
        $self = $this;
        return $this->cache::remember(
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
    }

    public function getStatistics(): string
    {
        return Cache::remember('users', now()->days(1), function () {
            $queryParams = [
                'lang' => 'ru-RU',
                'curr' => 'RUR',
            ];
            $platiResponse = $this->client->get($this->getPlatiBaseUrl(), [
                'query' => $queryParams
            ])->getBody()->getContents();
            $contentBegins = mb_strpos($platiResponse, '<div class="statistic">');
            $contentEnds = mb_strpos($platiResponse, '-->', $contentBegins);
            return mb_substr($platiResponse, $contentBegins, $contentEnds - $contentBegins);
        });
    }

    public function getProduct(int $id): SimpleXMLElement
    {
        $data = [
            'id_goods' => $id,
        ];
        $xml = $this->prepareXml($data);
        return $this->getResponseFromPlati($xml, 'goods_info');
    }

    public function getSections(?int $id = 0): SimpleXMLElement
    {
        $data = [
            'id_catalog' => $id,
            'rows' => self::DEFAULT_ROWS_COUNT
        ];
        $xml = $this->prepareXml($data);
        return $this->getResponseFromPlati($xml, 'sections');
    }

    public function getGoods(?int $id = null, int $page = 1): SimpleXMLElement
    {
        $data = [
            'id_section' => $id,
            'rows' => self::DEFAULT_ROWS_COUNT,
            'currency' => self::DEFAULT_CURRENCY,
            'page' => $page
        ];
        $xml = $this->prepareXml($data);
        return $this->getResponseFromPlati($xml, 'goods');
    }

    public function getSellerInfo(?int $id = null): SimpleXMLElement
    {
        $data = [
            'id_seller' => $id,
        ];
        $xml = $this->prepareXml($data);
        return $this->getResponseFromPlati($xml, 'seller_info');
    }

    public function getSearchData(?string $q = null, int $page = 1): array
    {
        $query = $this->prepareSearchQuery($q);
        $pageSize = self::SEARCH_PAGE_SIZE;
        $data = [];
        try {
            $result = $this->client->get($this->getPlatiBaseUrl()
                . "/api/search.ashx?query=$query&pagesize=$pageSize&response=json&pagenum=$page", [
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ]);
            $data = json_decode($result->getBody()->getContents(), true) ?: [];
            usort($data['items'], static function($item1, $item2){
                return $item1['price_rur'] <=> $item2['price_rur'];
            });
        } catch (Throwable $e) {

        }
        return $data;
    }

    public function getSearchPredictData(string $q = null): array
    {
        $result = $this->client->get($this->getPlatiBaseUrl()
            . "/asp/ajax.asp?action=as&q=$q&limit=10&timestamp=" . time(),
            [
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);
        $result = $result->getBody()->getContents();
        if (empty($result)) {
            $q = $this->switchStringLanguage($q);
            $result = $this->client->get($this->getPlatiBaseUrl()
                . "/asp/ajax.asp?action=as&q=$q&limit=10&timestamp=" . time(),
                [
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ]
                ]);
            $result = $result->getBody()->getContents();
        }
        if (empty($result)) {
            $q = $this->switchStringLanguage($q, true);
            $result = $this->client->get($this->getPlatiBaseUrl()
                . "/asp/ajax.asp?action=as&q=$q&limit=10&timestamp=" . time(),
                [
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ]
                ]);
            $result = $result->getBody()->getContents();
        }
        $words = [];
        $wordsData = explode("\n", $result);
        $wordsData = array_filter($wordsData);
        foreach ($wordsData as $word) {
            $index = mb_strpos($word, '|');
            $wordString = mb_substr($word, 0, $index);
            $wordLinkAddress = url(route('searchSlug', ['q' => $wordString]));
            $wordLink = "<a href='$wordLinkAddress'>$wordString</a>";
            $words[] = $wordLink;
        }
        return $words;
    }

    private function switchStringLanguage(string $string, bool $reverse = false)
    {
        $string = mb_strtolower($string);
        $strReplace = [
            'й' => 'q',
            'ц' => 'w',
            'у' => 'e',
            'к' => 'r',
            'е' => 't',
            'н' => 'y',
            'г' => 'u',
            'ш' => 'i',
            'щ' => 'o',
            'з' => 'p',
            'х' => '[',
            'ъ' => ']',
            'ф' => 'a',
            'ы' => 's',
            'в' => 'd',
            'а' => 'f',
            'п' => 'g',
            'р' => 'h',
            'о' => 'j',
            'л' => 'k',
            'д' => 'l',
            'ж' => ';',
            'э' => '\'',
            'я' => 'z',
            'ч' => 'x',
            'с' => 'c',
            'м' => 'v',
            'и' => 'b',
            'т' => 'n',
            'ь' => 'm',
            'б' => ',',
            'ю' => '.'
        ];
        if ($reverse) {
            $result = strtr($string, array_flip($strReplace));
        } else {
            $result = strtr($string, $strReplace);
        }

        return $result;
    }

    private function prepareSearchQuery(?string $q): string
    {
        $replacementArray = [
            '`' => "'"
        ];
        return urlencode(strtr($q, $replacementArray));
    }

    public function getResponses(int $sellerId, ?int $productId = null, int $rows = self::DEFAULT_ROWS_COUNT): array
    {
        $responses = [];
        $requestData = [
            'id_good' => (int)$productId,
            'id_seller' => $sellerId,
            'rows' => $rows
        ];
        $xml = $this->prepareXml($requestData);
        $result = $this->client->post($this->getPlatiBaseUrl() . '/xml/responses.asp', [
            'body' => $xml->asXML(),
            'headers' => [
                'Content-Type' => 'text/xml'
            ]
        ]);
        $data = simplexml_load_string($result->getBody()->getContents());
        if ($data !== null && !empty($data->rows->row)) {
            $responses = ((array)$data->rows)['row'] ?? [];
        }
        if (is_object($responses)) {
            $responses = [$responses];
        }
        return $responses;
    }

    public function getSellerGoods(?int $id = null): SimpleXMLElement
    {
        $data = [
            'id_seller' => $id,
            'rows' => self::DEFAULT_ROWS_COUNT,
            'currency' => self::DEFAULT_CURRENCY,
        ];
        $xml = $this->prepareXml($data);
        return $this->getResponseFromPlati($xml, 'seller_goods');
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
        $result = $this->client->post($this->getPlatiBaseUrl() . "/xml/$pageName.asp", [
            'body' => $xml->asXML(),
            'headers' => [
                'Content-Type' => 'text/xml'
            ]
        ]);
        return simplexml_load_string($result->getBody()->getContents());
    }
}