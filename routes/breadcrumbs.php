<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

// Home
Breadcrumbs::for('home', static function ($trail) {
    $trail->push('Главная', route('home'));
});

Breadcrumbs::for('catalog', static function ($trail) {
    $trail->parent('home');
    $trail->push('Каталог', route('catalog', route('catalog')));
});

// Home > Catalog > Category
Breadcrumbs::for('category', static function ($trail, $categoryTitle, $categoryId) {
    $trail->parent('home');
    $trail->push('Каталог', route('catalog', route('catalog')));
    $trail->push($categoryTitle, route ('category', $categoryId));
});

// Home > Catalog > Category > Product
Breadcrumbs::for('product', static function ($trail, $productTitle, $categoryId, $categoryTitle) {
    $trail->parent('catalog', $categoryTitle, $categoryId);
    $trail->push($productTitle);
});