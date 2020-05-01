<?php

namespace App\Http\Controllers;

use App\Page;
use Meta;

class PageController extends Controller
{
    public function show(string $slug)
    {
        $page = Page::where('slug', '=', $slug)->firstOrFail();

        Meta::set('title', $page->title . 'Главная | SellerStore.ru');
        Meta::set('description', $page->meta_description);
        Meta::set('keywords', $page->meta_keywords);

        return view('page', compact('page'));
    }
}
