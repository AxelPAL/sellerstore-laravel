<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Главная', route('home'));
});

// Home
Breadcrumbs::for('catalog', function ($trail, $categoryTitle, $categoryId) {
    $trail->parent('home');
    $trail->push('Каталог', route('catalog', route('catalog')));
    $trail->push($categoryTitle, route ('category', $categoryId));
});

// Home > Blog > [Category] > [Post]
Breadcrumbs::for('product', function ($trail, $productTitle, $categoryId, $categoryTitle) {
    $trail->parent('catalog', $categoryTitle, $categoryId);
    $trail->push($productTitle);
});