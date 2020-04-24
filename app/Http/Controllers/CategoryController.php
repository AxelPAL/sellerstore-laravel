<?php

namespace App\Http\Controllers;

use App\models\Plati;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class CategoryController extends Controller
{
    public function index(Plati $plati, Request $request, ?int $id = 0, int $page = 1)
    {
        /**
         *
            add_breadcrumb 'Каталог', :category_root_url, :if => category != 519
            unless @goods['name_section'].nil?
                add_breadcrumb @goods['name_section']
                prepare_meta_tags title: @goods['name_section']
            else
                prepare_meta_tags title: 'Каталог'
            end
         */

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

        return view('sections.index', compact('sidebar', 'statistics', 'q', 'categories', 'goods', 'paginator'));
    }
}
