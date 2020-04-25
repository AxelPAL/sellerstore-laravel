<?php
/** @var SimpleXMLElement $sellerInfo */
?>
@inject('helper', 'App\View\SellerView')
@extends('layouts.app')
@section('content')
    @php($statistics = $sellerInfo->statistics)
    <table class="striped highlight">
        <tr>
            <th>Продавец</th>
            <td>
                <img src="{{$helper->getSellerImage((float)$statistics->rating)}}" alt="">
                {{$sellerInfo->name_seller}}
                @if (strlen($sellerInfo->name_seller_long) > 0)
                    {{$sellerInfo->name_seller_long}}
                @endif
            </td>
        </tr>
        @if (!empty($statistics->rating))
        <tr>
            <th>Рейтинг</th>
            <td>{{$statistics->rating}}</td>
        </tr>
        @endif
        @if (!empty($sellerInfo->address))
        <tr>
            <th>Адрес</th>
            <td>{{$sellerInfo->address}}</td>
        </tr>
        @endif
        @if (!empty($sellerInfo->url))
        <tr>
            <th>Адрес сайта</th>
            <td>{{$sellerInfo->url}}</td>
        </tr>
        @endif
        @if (!empty($sellerInfo->fio))
        <tr>
            <th>ФИО</th>
            <td>{{$sellerInfo->fio}}</td>
        </tr>
        @endif
        @if (!empty($sellerInfo->phone))
        <tr>
            <th>Телефон</th>
            <td>{{$sellerInfo->phone}}</td>
        </tr>
        @endif
        @if (!empty($sellerInfo->icq))
        <tr>
            <th>ICQ</th>
            <td>{{$sellerInfo->icq}}</td>
        </tr>
        @endif
        @if (!empty($sellerInfo->skype))
        <tr>
            <th>Skype</th>
            <td>{{$sellerInfo->skype}}</td>
        </tr>
        @endif
        @if (!empty($sellerInfo->wmid))
        <tr>
            <th>WMID</th>
            <td>{{$sellerInfo->wmid}}</td>
        </tr>
        @endif
        @if (!empty($sellerInfo->date_registration))
        <tr>
            <th>Дата регистрации</th>
            <td>{{$sellerInfo->date_registration}}</td>
        </tr>
        @endif
        @if (!empty($statistics->cnt_goods))
        <tr>
            <th>Число продаваемых товаров</th>
            <td>{{$statistics->cnt_goods}}</td>
        </tr>
        @endif
        @if (!empty($statistics->cnt_sell))
        <tr>
            <th>Продаж</th>
            <td>{{$statistics->cnt_sell}}</td>
        </tr>
        @endif
        @if (!empty($statistics->cnt_return))
        <tr>
            <th>Возвратов</th>
            <td>{{$statistics->cnt_return}}</td>
        </tr>
        @endif
        @if (!empty($statistics->cnt_good_responses))
        <tr>
            <th>Количество положительных отзывов</th>
            <td>{{$statistics->cnt_good_responses}}</td>
        </tr>
        @endif
        @if (!empty($statistics->cnt_bad_responses))
        <tr>
            <th>Количество отрицательных отзывов</th>
            <td>{{ $statistics->cnt_bad_responses}}</td>
        </tr>
        @endif
    </table>

    <div class="load-goods"></div>
    <div class="load-responses"></div>
@stop