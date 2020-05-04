<?php

namespace App\Http\Controllers;

use App\Models\Paginator;
use App\Models\Plati;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Meta;

class SearchController extends Controller
{
    protected const DEFAULT_PAGE_VALUE = 1;

    public function index(Plati $plati, Request $request, Logger $logger, ?string $q = null)
    {
        $q = $request->get('q', $q);
        $page = $request->get('page', self::DEFAULT_PAGE_VALUE);
        $searchData = $plati->getSearchData($q, $page);
        if (empty($searchData)) {
            $searchData['total'] = 0;
            $logger->warning('Search data is unavailable!');
        }
        $itemsCount = $searchData['total'];
        $items = range(0, $itemsCount);
        $paginator = new Paginator($items, $itemsCount, Plati::SEARCH_PAGE_SIZE, $page);
        if (!empty($q)) {
            $paginator->setPath(route('searchSlug', ['q' => $q]));
        }
        Meta::set('title', 'Поиск ' . $q . ' | SellerStore.ru');
        Meta::set('description', 'SellerStore.ru - поиск цифровых товаров и ключей для игр с мгновенной выдачей');
        Meta::set('keywords', implode(', ', ['купить', 'игру', 'ключ', 'steam', 'steam-ключи', 'steam-игры']));

        return view('search.index', compact('searchData', 'q', 'paginator'));
    }

    public function predict(Plati $plati, Request $request, string $q)
    {
        $q = $request->get('q', $q);
        $productsData = $plati->getSearchPredictData($q);
        return response()->json($productsData);
    }
}
