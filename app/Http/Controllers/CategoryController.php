<?php

namespace App\Http\Controllers;

use App\Models\Paginator;
use App\Models\Plati;
use Illuminate\Http\Request;
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
        $itemsCount = (int)$goods->{'cnt_goods'};
        $items = range(0, $itemsCount);
        $paginator = new Paginator($items, $itemsCount, Plati::DEFAULT_ROWS_COUNT, $page);
        $paginator->setPath(route('category', ['id' => $id]));

        $title = (string)$goods->{'name_section'} ?: 'Каталог';
        Meta::set('title', $title . ' | SellerStore.ru');
        Meta::set('description', 'Интернет магазин цифровых товаров');
        Meta::set('keywords',
            implode(', ', ['продажа', 'цифровые', 'ключи', 'steam', 'steam-ключи', 'steam-игры', 'купить', 'ключ',]));

        return view('sections.index', compact('categories', 'goods', 'paginator', 'id'));
    }
}
