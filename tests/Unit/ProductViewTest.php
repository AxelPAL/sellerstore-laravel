<?php

namespace Tests\Unit;

use App\View\ProductView;
use Tests\TestCase;

class ProductViewTest extends TestCase
{
    public function testReplaceLinksToPlatiStripsQueryTailFromProductLinks(): void
    {
        config(['app.url_domain' => 'sellerstore.ru']);
        putenv('APP_URL_DOMAIN=sellerstore.ru');

        $helper = new ProductView();

        $content = 'https://sellerstore.ru/asp/pay.asp?id_d=2202350&lang=ru-RU';

        $this->assertSame(
            'https://sellerstore.ru/products/2202350',
            $helper->replaceLinksToPlati($content)
        );
    }
}
