@inject('helper', 'App\View\ProductView')
@extends('layouts.app')
@section('content')
    <h1>{{$product->name_goods}}</h1>
    <div class="product-info">
        <div class="main-block col s12">
            <div class="col s12 m12 l9">
                <table id="product-info-table" class="highlight centered responsive-table" data-step="1" data-intro="Здесь представлена информация по данному товару: продавец, продажи и отзывы.">
                    <thead>
                    <tr>
                        <th>Продавец</th>
                        <th>Продано</th>
                        <th>Возвратов</th>
                        <th>Отзывы</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><a href="/seller/{{$product->id_seller}}">{{$product->name_seller}}</a></td>
                        <td>{{$product->cnt_sell}}</td>
                        <td>{{$product->cnt_return}}</td>
                        <td class="table-review-cell">
                            @if ($product->statistics->cnt_goodresponses)
                            <table>
                                <tr><td colspan="2">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success waves-effect" role="progressbar" style="width:{{$helper->calculateGoodResponsesPercent($product)}}%">
                                                <span>{{$product->statistics->cnt_goodresponses}}</span>
                                            </div>
                                            <div class="progress-bar progress-bar-danger waves-effect" role="progressbar" style="width:{{$helper->calculateBadResponsesPercent($product)}}%">
                                                <span>{{$product->statistics->cnt_badresponses}}</span>
                                            </div>
                                        </div>
                                    </td></tr>
                            </table>
                            @else
                                <p>Отзывов еще нет</p>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
{{--                <div class="col s12">--}}
{{--                    <div class="images">--}}
{{--                        @if ($product_images)--}}
{{--                        <div class="product-slider">--}}
{{--                            <% @product_images.each do |image| %>--}}
{{--                            <a class="swipebox" title="Изображение <%= image['id'].to_s %> из <%= @product_images.length %>" href="<%= image['img_real'] %>">--}}
{{--                                <img src="<%= image['img_small'] %>" alt=""/>--}}
{{--                            </a>--}}
{{--                            <% end %>--}}
{{--                        </div>--}}
{{--                        <% end %>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
            <div class="buy-block col s12 m12 l3" data-step="5" data-intro="В конечном итоге, если товар вам подходит - вы можете посмотреть, сколько он стоить и купить его в данном блоке. Спасибо, что посмотрели тур по сайту. Удачи вам в приобритении товаров в нашем магазине..">
                <div class="card blue-grey darken-1">
                    @if ($product->price > 0)
                        <div class="card-content white-text">
                            <div class="price"><span>₽</span> {{number_format((float)$product->price, 2, ',', ' ')}}</div>
                        </div>
                    @endif
                    <div class="card-action">
                        @if ($product->price > 0 && $product->available_goods > 0 )
                            <%= form_tag '/buy-product', :method => 'GET' do %>
                            <input id="product-id" name="product" type="hidden" value="<%= $product.plati_id %>"/>
                            <button class="btn waves-effect waves-light" type="submit">
                                <i class="material-icons left buy-button">verified_user</i><!--<i class="material-icons left search"></i>-->Купить
                            </button>
                        @else
                            <div class="nothing-to-buy">Эта позиция полностью куплена.</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="description" data-step="2" data-intro="Описание товара можете прочитать чуть ниже, сразу после галереи изображений.">
                    <div class="description-title product-title">Описание</div>
                    {{$product->info}}
                </div>
                @unless (empty($product->add_info))
                    <div class="add_description" data-step="3" data-intro="Обязательно прочитайте дополнительную информацию. Здесь продавцы часто указывают важные примечания к данному товару.">
                        <div class="description-title product-title">Дополнительное описание</div>
                        {{$product->add_info}}
                    </div>
                @endunless
{{--                @unless @responses.empty?--}}
{{--                <div class="comments" id="comments" data-step="4" data-intro="Вы всегда можете прочитать отзывы, которые оставляют другие покупатели именно к выбранному товару.">--}}
{{--                    <div class="product-title">Отзывы</div>--}}
{{--                    <div class="comments-wrapper" id="comments-wrapper">--}}
{{--                        <ul class="pagination"></ul>--}}
{{--                        <ul class="list">--}}
{{--                            <% cache do %>--}}
{{--                            <% @responses.each do |response| %>--}}
{{--                            <li class="comment <%= response[:type] %>">--}}
{{--                                <div class="comment-date"><%= response[:date] %></div>--}}
{{--                                <div class="comment-text"><%= HTMLEntities.new.decode HTMLEntities.new.decode response[:text] %></div>--}}
{{--                                <%if response[:comment].length > 0%>--}}
{{--                                <div class="comment-response">Ответ продавца: <%= HTMLEntities.new.decode HTMLEntities.new.decode response[:comment] %></div>--}}
{{--                                <% end %>--}}
{{--                            </li>--}}
{{--                            <% end %>--}}
{{--                            <% end %>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <%end%>--}}
            </div>
        </div>
    </div>
@stop