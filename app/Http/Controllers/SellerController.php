<?php

namespace App\Http\Controllers;

use App\Models\Plati;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Meta;

class SellerController extends Controller
{
    /**
     * @param Plati $plati
     * @param int $id
     * @return View|Factory
     * @throws GuzzleException
     */
    public function index(Plati $plati, int $id): View|Factory
    {
        $sellerInfo = $plati->getSellerInfo($id);
        Meta::set('title', 'Продавец ' . $sellerInfo->{'name_seller'} . ' | SellerStore.ru');

        /** @var view-string $view */
        $view = 'seller.index';

        return view($view, compact('sellerInfo'));
    }

    /**
     * @param Plati $plati
     * @param int $id
     * @return View|Factory
     * @throws GuzzleException
     */
    public function goods(Plati $plati, int $id): View|Factory
    {
        $productsData = $plati->getSellerGoods($id);
        $products = $productsData->{'rows'}->{'row'};
        /** @var view-string $view */
        $view = 'seller.goods';

        return view($view, compact('products'));
    }

    /**
     * @param Plati $plati
     * @param int $id
     * @return View|Factory
     * @throws GuzzleException
     */
    public function responses(Plati $plati, int $id): View|Factory
    {
        $responses = $plati->getResponses($id);

        /** @var view-string $view */
        $view = 'seller.responses';

        return view($view, compact('responses'));
    }
}
