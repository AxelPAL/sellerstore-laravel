<?php

namespace App\Http\Controllers;

use App\models\HomePageItems;

class HomeController extends Controller
{
    public function index(HomePageItems $homePageItems)
    {
        $popularCategories = $homePageItems->getPopularCategories();
        $items = $homePageItems->parseHomeItems();
        return view('home', compact('popularCategories', 'items'));
    }
}
