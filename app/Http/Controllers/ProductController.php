<?php

namespace App\Http\Controllers;

use App\models\Plati;

class ProductController extends Controller
{
    public function product($id, Plati $plati)
    {
        $q = '';
        $product = $plati->getProduct($id);

        //transformations
        $product->price = $product->price_goods->wmr;

        //transformations

        $sidebar = $plati->getSidebar();
        return view('product', compact('product', 'q', 'sidebar'));
    }
}
