<?php

namespace App\View;

use Asika\Autolink\Linker;
use SimpleXMLElement;

class ProductView
{
    public function calculateGoodResponsesPercent(SimpleXMLElement $product): float|int
    {
        $goodResponses = (float)($product->statistics->cnt_goodresponses);
        $badResponses = (float)($product->statistics->cnt_badresponses);
        $percent = 0;
        if (($goodResponses + $badResponses) > 0) {
            $percent = $goodResponses / ($goodResponses + $badResponses) * 100;
        }
        if ($percent > 80) {
            $percent = 80;
        }
        return $percent;
    }

    public function calculateBadResponsesPercent(SimpleXMLElement $product): float|int
    {
        $goodResponses = (float)($product->statistics->cnt_goodresponses);
        $badResponses = (float)($product->statistics->cnt_badresponses);
        $percent = 0;
        if (($goodResponses + $badResponses) > 0) {
            $percent = $badResponses / ($goodResponses + $badResponses) * 100;
        }
        if ($percent < 20) {
            $percent = 20;
        }
        return $percent;
    }

    public function replaceLinksToPlati(string $content): string
    {
        $sellerstoreDomain = env('APP_URL_DOMAIN');
        $replacements = [
            ['plati.com', $sellerstoreDomain],
            ['PLATI.COM', $sellerstoreDomain],
            ['plati.market', $sellerstoreDomain],
            ['plati.io', $sellerstoreDomain],
            ['plati.ru', $sellerstoreDomain],
            ['PLATI.RU', $sellerstoreDomain],
            ["$sellerstoreDomain/asp/pay.asp?id_d=", "$sellerstoreDomain/products/"],
            ['www.', ''],
            ["$sellerstoreDomain/asp/pay.asp?idd=", "$sellerstoreDomain/products/"],
            ["$sellerstoreDomain/asp/seller.asp?id_s=", "$sellerstoreDomain/seller/"],
            ['/\/asp\/list_seller.asp\?id_s=/', '/seller/'],
            ['&id=good', '/goods'],
            ['.asp?', ''],
            ["/itm\/(\d+)/gi", ''],
            ["$sellerstoreDomain/asp/", ''],
        ];
        foreach ($replacements as $replacement) {
            $content = str_replace($replacement[0], $replacement[1], $content);
        }
        $content = preg_replace('/\/itm\/(\d+)/i', '/products/$1', (string)$content);
        $content = preg_replace('/\/seller\/(\w+)\/(\w+)/i', '/seller/$2', (string)$content);
        return (string)$content;
    }

    public function prepareDescription(string $content): string
    {
        $content = html_entity_decode(html_entity_decode($content));
        $content = $this->replaceLinksToPlati($content);
        $replacements = [
            ["\n", '<br />'],
            ['?', ''],
        ];
        foreach ($replacements as $replacement) {
            $content = str_replace($replacement[0], $replacement[1], $content);
        }
        $content = autolink($content, null);
        return $content;
    }
}
