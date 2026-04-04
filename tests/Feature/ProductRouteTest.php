<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductController;
use App\Models\UserAgent;
use ReflectionMethod;
use Tests\TestCase;

class ProductRouteTest extends TestCase
{
    public function testNormalizeProductIdAcceptsBrokenLangSuffixInPath(): void
    {
        $controller = new ProductController(new UserAgent());
        $method = new ReflectionMethod(ProductController::class, 'normalizeProductId');
        $method->setAccessible(true);

        $this->assertSame(2202350, $method->invoke($controller, '2202350&lang=ru-RU'));
    }
}
