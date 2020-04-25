<?php

namespace App\Http\Controllers;

use App\Models\Plati;
use Meta;

class SellerController extends Controller
{
    public function index(Plati $plati, int $id)
    {
        $sellerInfo = $plati->getSellerInfo($id);
        Meta::set('title', 'Продавец' . $sellerInfo->{'name_seller'} . ' | SellerStore.ru');

        return view('seller.index', compact('sellerInfo'));
    }

    public function goods(Plati $plati, int $id)
    {
        $productsData = $plati->getSellerGoods($id);
        $products = $productsData->{'rows'}->{'row'};
        return view('seller.goods', compact('products'));
    }

    public function responses(Plati $plati, int $id)
    {
        $responses = $plati->getResponses($id);

        return view('seller.responses', compact('responses'));

    }
}
