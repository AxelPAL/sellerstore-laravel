@inject('helper', 'App\View\ProductView')
@extends('layouts.app')
@section('content')
    <h1>Поиск продукции</h1>
    <div class="row">
        <form action="/search" method="GET">
            <div class="input-field js-search-div search-wrapper col s12 m6 l6">
                <i class="material-icons prefix">search</i>
                <input class="query" id="query" name="q" required preloader="Поисковый запрос" type="search" value="{{$q}}"/>
                <label class="active search-page-label" for="query">Поиск</label>
            </div>
            <div class="predict-menu col s12">
                <div></div>
            </div>
            <div class="col s12 m6 l6 search-button-div">
                <button class="waves-effect waves-light btn search-button orange accent-4" type="submit">
                    <i class="material-icons left search"></i>Найти
                </button>
            </div>
        </form>
    </div>
    <div class="found-count">Найдено товаров: {{$searchData['total']}}</div>
    @if (!empty($searchData['items']))
        <table class="hoverable search-table">
            <thead>
            <tr>
                <th>Имя</th>
                <th>Цена</th>
            </tr>
            </thead>
            <tbody>

            @foreach($searchData['items'] as $product)
                <tr>
                    <td>
                        <a class="waves-effect waves-teal btn-flat"
                           href="{{"/products/{$product['id']}"}}">{{$helper->prepareDescription($product['name'] ?: $product['name_eng'])}}</a>
                    </td>
                    <td class="price-sign">{{number_format($product['price_rur'], 0, '.', ' ')}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$paginator->links()}}
    @endif
@stop