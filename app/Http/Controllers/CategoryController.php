<?php

namespace App\Http\Controllers;

use App\models\Plati;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Meta;

class CategoryController extends Controller
{
    public function index(Plati $plati, Request $request, ?int $id = 0, int $page = 1)
    {
        $requestPage = $request->get('page');
        if ($requestPage !== null) {
            $page = $requestPage;
        }
        $sections = $plati->getSections($id);
        $goods = $plati->getGoods($id, $page);
        $foldersData = $sections->{'folder'};
        $sectionsData = $sections->{'section'};
        $categories = [];
        foreach ($foldersData as $folder) {
            $categories[(string)$folder->{'name_folder'}] = $folder;
        }
        foreach ($sectionsData as $section) {
            $categories[(string)$section->{'name_section'}] = $section;
        }
        ksort($categories);
        $q = '';
        $sidebar = $plati->getSidebar();
        $statistics = $plati->getStatistics();
        $itemsCount = (int)$goods->{'cnt_goods'};
        $paginator = new Paginator(range(0, $itemsCount), Plati::DEFAULT_RAWS_COUNT, $page);
        $paginator->setPath(route('category', ['id' => $id]));

        $title = (string)$goods->{'name_section'} ?: '';
        Meta::set('title', $title . ' | SellerStore.ru');
        Meta::set('description', 'Интернет магазин цифровых товаров');
        Meta::set('keywords',
            implode(', ', ['продажа', 'цифровые', 'ключи', 'steam', 'steam-ключи', 'steam-игры', 'купить', 'ключ',]));

        return view('sections.index', compact('sidebar', 'statistics', 'q', 'categories', 'goods', 'paginator', 'id'));
    }
}
