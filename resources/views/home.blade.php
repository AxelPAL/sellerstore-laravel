@extends('layouts.app')
@section('content')
    <h2 class="main-page_header">Популярные категории</h2>
    <div class="main-page_categories">
        @if (!empty($popularCategories))
            @foreach($popularCategories as $popularCategory)
                <div class="main-page_category">
                    <a href="/category/{{$popularCategory['id']}}">
                        <span>{{$popularCategory['name']}}</span>
                    </a>
                </div>
            @endforeach
        @endif
    </div>

    <h2 class="main-page_header">Популярные товары</h2>
    <div
        @if (Request::get('tour') === '1')
        data-step=4
        data-intro="Здесь отображаются популярные товары на текущий момент. Можете кликнуть на любой из них и мы продолжим обучение."
        @endif
        class="main-page_items">
        @if (!empty($items))
            @foreach($items as $item)
                <div>
                    <a href="/products/{{$item['id']}}{{Request::get('tour') === '1' ? '?tour=2' : ''}}">
                        <img src={{$item['image']}} alt=""/>
                        <span>{{$item['name']}}</span>
                        <strong>{{$item['price']}} <span class="ruble"></span></strong>
                    </a>
                </div>
            @endforeach
        @endif
    </div>
@stop
