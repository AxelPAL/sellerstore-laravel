<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Главная', route('home'));
});

// Home
Breadcrumbs::for('catalog', function ($trail) {
    $trail->parent('home');
    $trail->push('Каталог', route('catalog'));
});

// Home > Blog > [Category] > [Post]
Breadcrumbs::for('product', function ($trail, $productTitle, $sectionId, $sectionTitle) {
    $trail->parent('catalog');
    $trail->push($sectionTitle, route('category', $sectionId));
    $trail->push($productTitle);
});