<?php

namespace App\Http\Controllers;

use App\models\HomePageItems;

class HomeController extends Controller
{
    public function index(HomePageItems $homePageItems)
    {
        $popularCategories = $homePageItems->getPopularCategories();
        $items = $homePageItems->parseHomeItems();
        $q = '';
        $sidebar = $homePageItems->getSidebar();
        return view('home', compact('popularCategories', 'items', 'q', 'sidebar'));
    }
}
