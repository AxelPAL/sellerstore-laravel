<?php

namespace App\View;

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

    public function replaceLinksToPlati(string $content)
    {
        $platiUrl = env('PLATI_BASE_DOMAIN');
        $replacements = [
            ['plati.com', $platiUrl],
            ['plati.market', $platiUrl],
            ['plati.io', $platiUrl],
            ['plati.ru', $platiUrl],
            ['/\w+.plati.ru\/asp\/list_seller.asp\?id_s=/', "$platiUrl/seller/"],
            ['plati.ru/asp/pay.asp?id_d=', "$platiUrl/products/"],
            ['www.', ''],
            ['plati.ru/asp/pay.asp?idd=', "$platiUrl/products/"],
            ['plati.ru/asp/seller.asp?id_s=', "$platiUrl/seller/"],
//        [/plati.ru\/seller\/(\w+)\/(\w+)/){ "$platiUrl/seller/" + Regexp.last_match[2] ],
            ['&id=good', '/goods'],
            ['.asp?', ''],
//            [/plati.ru\/itm\/(\d+)/) { "$platiUrl/products/" + Regexp.last_match[1]],
            ['plati.ru/asp/', ''],
        ];
        foreach ($replacements as $replacement) {
            $content = str_replace($replacement[0], $replacement[1], $content);
        }
        return $content;
    }
    /*
  def render_html(html)
    html = HTMLEntities.new.decode(HTMLEntities.new.decode(html))
    html = simple_format(html, {}, sanitize: false)
    html = replace_links_to_plati(html)
    html = Rinku.auto_link(html)
    raw html
  end

  def replace_links_to_plati(html)
    domain_name = APP_CONFIG['domain_name']
    html.gsub('plati.com', 'plati.ru')
        .gsub('plati.market', 'plati.ru')
        .gsub('plati.io', 'plati.ru')
        .gsub(/\w+.plati.ru\/asp\/list_seller.asp\?id_s=/, "#{domain_name}/seller/")
        .gsub('plati.ru/asp/pay.asp?id_d=', "#{domain_name}/products/")
        .gsub('www.', '')
        .gsub('plati.ru/asp/pay.asp?idd=', "#{domain_name}/products/")
        .gsub('plati.ru/asp/seller.asp?id_s=', "#{domain_name}/seller/")
        .gsub(/plati.ru\/seller\/(\w+)\/(\w+)/){ "#{domain_name}/seller/" + Regexp.last_match[2] }
        .gsub('&id=good', '/goods')
        .gsub('.asp?', '')
        .gsub('plati.ru/asp/', '')
        .gsub(/plati.ru\/itm\/(\d+)/) { "#{domain_name}/products/" + Regexp.last_match[1]}
        .gsub('plati.ru', domain_name)
  end
     * */
}