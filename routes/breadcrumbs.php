<?php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;
// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('home', static function (BreadcrumbTrail $trail) {

    $trail->push('Главная', route('home'));
});
Breadcrumbs::for('catalog', static function (BreadcrumbTrail $trail) {

    $trail->parent('home');
    $trail->push('Каталог', route('catalog'));
});
Breadcrumbs::for('category', static function (BreadcrumbTrail $trail, $categoryTitle, $categoryId) {

    $trail->parent('home');
    $trail->push('Каталог', route('catalog'));
    $trail->push($categoryTitle, route('category', ['id' => $categoryId]));
});
Breadcrumbs::for('product', static function (BreadcrumbTrail $trail, $productTitle, $categoryId, $categoryTitle) {

    $trail->parent('category', $categoryTitle, $categoryId);
    $trail->push($productTitle);
});
