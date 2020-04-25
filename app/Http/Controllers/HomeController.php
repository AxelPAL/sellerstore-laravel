<?php

namespace App\Http\Controllers;

use App\Models\HomePageItems;
use Meta;

class HomeController extends Controller
{
    public function index(HomePageItems $homePageItems)
    {
        $popularCategories = $homePageItems->getPopularCategories();
        $items = $homePageItems->parseHomeItems();

        Meta::set('title', 'Главная | SellerStore.ru');
        Meta::set('description', 'SellerStore.ru - продажа цифровых товаров и ключей для игр с мгновенной выдачей');
        Meta::set('keywords',
            implode(', ', ['купить', 'игру', 'ключ', 'steam', 'steam-ключи', 'steam-игры']));

        return view('home', compact('popularCategories', 'items'));
    }
}
