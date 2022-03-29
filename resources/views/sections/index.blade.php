@inject('helper', 'App\View\ProductView')
@extends('layouts.app')
@section('breadcrumbs')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('category', $goods->name_section ?: '', $id) }}
@stop
@section('content')
@if (!empty($goods->name_section))
    <h1>{{$goods->name_section}}</h1>
@elseif ($goods->rows->attributes()['cnt'] > 0)
    <h1>Разделы сайта</h1>
@endif
<div class="content-zone">
    @if (!empty($categories))
        @foreach($categories as $folder)
            @if (!empty($folder))
                <div class="section">
                    <div class="section-title">
                        <a href="/category/{{$folder->attributes()['id']}}">{!! $folder->name_section ?? $folder->name_folder !!}</a>
                        <span class="badge" title="Количество товаров в категории">{{$folder->cnt_goods}}</span>
                        <div>
                            <ul class="collection">
                                @if (!empty($folder->folder))
                                    @foreach($folder->folder as $x)
                                        <li class="collection-item">
                                            <a href="/category/{{(int)$x->attributes()['id']}}">
                                                {!! $x->name_folder !!}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                                @if (!empty($folder->section))
                                    @foreach($folder->section as $z)
                                        <li class="collection-item">
                                            <a href="/category/{{(int)$z->attributes()['id']}}">
                                                {!! $z->name_section !!}
                                            </a>
                                            <span class="badge"
                                                  title="Количество товаров в категории">{{$z->cnt_goods}}</span>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
    @if (!empty($goods) && !empty($goods->rows->row))
        <table class="highlight hoverable sections-table sort">
            <thead>
            <tr>
                <th>Название</th>
                <th>Цена</th>
                <th>Продавец</th>
                <th>Рейтинг продавца</th>
                <th>Продано</th>
            </tr>
            </thead>
            <tbody>
            @foreach($goods->rows->row as $good)
                <tr>
                    <td>
                        <a href="/products/{{$good->id_goods}}">{!! $helper->prepareDescription(html_entity_decode($good->name_goods)) !!}
                        </a></td>
                    <td class="price-sign">{{str_replace(',', '.', $good->price)}}</td>
                    <td>
                        <a href="/seller/{{$good->id_seller}}">{!! $helper->prepareDescription(html_entity_decode($good->name_seller)) !!}
                        </a></td>
                    <td>{{$good->rating}}</td>
                    <td>{{$good->statistics->cnt_sell}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    {{$paginator->links()}}
    @stop
</div>