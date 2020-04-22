<?php

namespace App\View;

use Asika\Autolink\Linker;
use SimpleXMLElement;

class ProductView
{
    public function calculateGoodResponsesPercent(SimpleXMLElement $product)
    {
        $goodResponses = $product->statistics->cnt_goodresponses;
        $badResponses = $product->statistics->cnt_badresponses;
        $percent = 0;
        if (($goodResponses + $badResponses) > 0) {
            $percent = $goodResponses / ($goodResponses + $badResponses) * 100;
        }
        if ($percent > 80) {
            $percent = 80;
        }
        return $percent;
    }

    public function calculateBadResponsesPercent(SimpleXMLElement $product)
    {
        $goodResponses = $product->statistics->cnt_goodresponses;
        $badResponses = $product->statistics->cnt_badresponses;
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
        $platiUrl = env('PLATI_BASE_DOMAIN');
        $replacements = [
            ['plati.com', $platiUrl],
            ['plati.market', $platiUrl],
            ['plati.io', $platiUrl],
            ['plati.ru', $platiUrl],
            ["$platiUrl/asp/pay.asp?id_d=", "$platiUrl/products/"],
            ['www.', ''],
            ["$platiUrl/asp/pay.asp?idd=", "$platiUrl/products/"],
            ["$platiUrl/asp/seller.asp?id_s=", "$platiUrl/seller/"],
            ['/\/asp\/list_seller.asp\?id_s=/', '/seller/'],
            ['&id=good', '/goods'],
            ['.asp?', ''],
            ["/itm\/(\d+)/gi", ''],
            ["$platiUrl/asp/", ''],
        ];
        foreach ($replacements as $replacement) {
            $content = str_replace($replacement[0], $replacement[1], $content);
        }
        $content = preg_replace('/\/itm\/(\d+)/i', '/products/$1', $content);
        $content = preg_replace('/\/seller\/(\w+)\/(\w+)/i', '/seller/$2', $content);
        return $content;
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