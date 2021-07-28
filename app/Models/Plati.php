<?php

namespace App\Models;

use Cache;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Psr\SimpleCache\InvalidArgumentException;
use SimpleXMLElement;
use Throwable;

class Plati
{
    public const DEFAULT_ROWS_COUNT = 100;
    public const SEARCH_PAGE_SIZE = 500;
    protected const DEFAULT_CURRENCY = 'RUR';
    protected const CACHE_STATISTICS_KEY = 'Statistics';
    protected const CACHE_SIDEBAR_KEY = 'Sidebar';

    private Client $client;
    private Cache $cache;

    public function __construct(Client $client, Cache $cache)
    {
        $this->client = $client;
        $this->cache = $cache;
    }

    /**
     * @throws InvalidArgumentException
     * @throws JsonException
     */
    public function getSidebar(): array
    {
        $sidebarData = [
            'id_catalog' => 0,
            'rows'       => 500,
        ];
        $xml = $this->prepareXml($sidebarData);
        $content = $this->getResponseFromPlati($xml, 'sections');
        $sidebarContent = json_decode(
            json_encode((array)$content->folder, JSON_THROW_ON_ERROR),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $this->cache::set(self::CACHE_SIDEBAR_KEY, $sidebarContent, now()->hours(12));

        return $sidebarContent;
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

    /**
     * @param SimpleXMLElement $xml
     * @param string $pageName
     * @return SimpleXMLElement
     * @throws GuzzleException
     */
    private function getResponseFromPlati(SimpleXMLElement $xml, string $pageName): SimpleXMLElement
    {
        $result = $this->client->post($this->getPlatiBaseUrl() . "/xml/$pageName.asp", [
            'body'    => $xml->asXML(),
            'headers' => [
                'Content-Type' => 'text/xml',
                'User-Agent'   => env('USER_AGENT_FOR_PLATI'),
            ],
        ]);
        $content = $result->getBody()->getContents();
        return simplexml_load_string($content);
    }

    public function getPlatiBaseUrl(): string
    {
        return env('PLATI_BASE_URL', '');
    }

    public function getSidebarFromCache(): array
    {
        return $this->cache::get(self::CACHE_SIDEBAR_KEY, []);
    }

    /**
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    public function getStatistics(): string
    {
        $queryParams = [
            'lang' => 'ru-RU',
            'curr' => 'RUR',
        ];
        $platiResponse = $this->client->get($this->getPlatiBaseUrl(), [
            'query'   => $queryParams,
            'headers' => [
                'User-Agent' => env('USER_AGENT_FOR_PLATI'),
            ],
        ])->getBody()->getContents();
        $contentBegins = mb_strpos($platiResponse, '<div class="statistic">');
        $contentEnds = mb_strpos($platiResponse, '-->', $contentBegins);
        $statistics = mb_substr($platiResponse, $contentBegins, $contentEnds - $contentBegins);
        $this->cache::set(self::CACHE_STATISTICS_KEY, $statistics, now()->days(1));

        return $statistics;
    }

    public function getStatisticsFromCache(): string
    {
        return $this->cache::get(self::CACHE_STATISTICS_KEY, '');
    }

    /**
     * @param int $id
     * @return SimpleXMLElement
     * @throws GuzzleException
     */
    public function getProduct(int $id): SimpleXMLElement
    {
        $data = [
            'id_goods' => $id,
        ];
        $xml = $this->prepareXml($data);
        return $this->getResponseFromPlati($xml, 'goods_info');
    }

    /**
     * @param int|null $id
     * @return SimpleXMLElement
     * @throws GuzzleException
     */
    public function getSections(?int $id = 0): SimpleXMLElement
    {
        $data = [
            'id_catalog' => $id,
            'rows'       => self::DEFAULT_ROWS_COUNT,
        ];
        $xml = $this->prepareXml($data);
        return $this->getResponseFromPlati($xml, 'sections');
    }

    /**
     * @param int|null $id
     * @param int $page
     * @return SimpleXMLElement
     * @throws GuzzleException
     */
    public function getGoods(?int $id = null, int $page = 1): SimpleXMLElement
    {
        $data = [
            'id_section' => $id,
            'rows'       => self::DEFAULT_ROWS_COUNT,
            'currency'   => self::DEFAULT_CURRENCY,
            'page'       => $page,
        ];
        $xml = $this->prepareXml($data);
        return $this->getResponseFromPlati($xml, 'goods');
    }

    /**
     * @param int|null $id
     * @return SimpleXMLElement
     * @throws GuzzleException
     */
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
                    'Content-Type' => 'application/json',
                    'User-Agent'   => env('USER_AGENT_FOR_PLATI'),
                ],
            ]);
            $data = json_decode($result->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR) ?: [];
            usort($data['items'], static function ($item1, $item2) {
                return $item1['price_rur'] <=> $item2['price_rur'];
            });
        } catch (Throwable $e) {
        }
        return $data;
    }

    private function prepareSearchQuery(?string $q): string
    {
        $replacementArray = [
            '`' => "'",
        ];
        return urlencode(strtr($q, $replacementArray));
    }

    /**
     * @param string|null $q
     * @return array
     * @throws GuzzleException
     */
    public function getSearchPredictData(string $q = null): array
    {
        $result = $this->client->get(
            $this->getPlatiBaseUrl() . "/asp/ajax.asp?action=as&q=$q&limit=10&timestamp=" . time(),
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'User-Agent'   => env('USER_AGENT_FOR_PLATI'),
                ],
            ]
        );
        $result = $result->getBody()->getContents();
        if (empty($result)) {
            $q = $this->switchStringLanguage($q);
            $result = $this->client->get(
                $this->getPlatiBaseUrl() . "/asp/ajax.asp?action=as&q=$q&limit=10&timestamp=" . time(),
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'User-Agent'   => env('USER_AGENT_FOR_PLATI'),
                    ],
                ]
            );
            $result = $result->getBody()->getContents();
        }
        if (empty($result)) {
            $q = $this->switchStringLanguage($q, true);
            $result = $this->client->get(
                $this->getPlatiBaseUrl() . "/asp/ajax.asp?action=as&q=$q&limit=10&timestamp=" . time(),
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'User-Agent'   => env('USER_AGENT_FOR_PLATI'),
                    ],
                ]
            );
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
            'ю' => '.',
        ];
        if ($reverse) {
            $result = strtr($string, array_flip($strReplace));
        } else {
            $result = strtr($string, $strReplace);
        }

        return $result;
    }

    /**
     * @throws GuzzleException
     */
    public function getResponses(int $sellerId, ?int $productId = null, int $rows = self::DEFAULT_ROWS_COUNT): array
    {
        $responses = [];
        $requestData = [
            'id_good'   => (int)$productId,
            'id_seller' => $sellerId,
            'rows'      => $rows,
        ];
        $xml = $this->prepareXml($requestData);
        $result = $this->client->post(
            $this->getPlatiBaseUrl() . '/xml/responses.asp',
            [
                'body'    => $xml->asXML(),
                'headers' => [
                    'Content-Type' => 'text/xml',
                    'User-Agent'   => env('USER_AGENT_FOR_PLATI'),
                ],
            ]
        );
        $data = simplexml_load_string($result->getBody()->getContents());
        if ($data !== null && !empty($data->rows->row)) {
            $responses = ((array)$data->rows)['row'] ?? [];
        }
        if (is_object($responses)) {
            $responses = [$responses];
        }
        return $responses;
    }

    /**
     * @param int|null $id
     * @return SimpleXMLElement
     * @throws GuzzleException
     */
    public function getSellerGoods(?int $id = null): SimpleXMLElement
    {
        $data = [
            'id_seller' => $id,
            'rows'      => self::DEFAULT_ROWS_COUNT,
            'currency'  => self::DEFAULT_CURRENCY,
        ];
        $xml = $this->prepareXml($data);
        return $this->getResponseFromPlati($xml, 'seller_goods');
    }
}
