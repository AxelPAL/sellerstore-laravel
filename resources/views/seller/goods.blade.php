@inject('helper', 'App\View\ProductView')
<h2 class="seller-goods-title">Товары продавца</h2>
@if (!empty($products))
    <table class="highlight hoverable sections-table sort goods-table">
        <thead>
        <tr>
            <th>Название</th>
            <th>Цена</th>
            <th>Продано</th>
            <th>Возвратов</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>
                    <a href="/products/{{$product->id_goods}}">{{$helper->prepareDescription($product->name_goods)}}</a>
                </td>
                <td>{{$product->price}}</td>
                <td>{{$product->cnt_sell}}</td>
                <td>{{$product->cnt_return}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif