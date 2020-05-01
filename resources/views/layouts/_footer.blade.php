<footer class="page-footer orange accent-3">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">Информация о сайте</h5>
                <p class="grey-text text-lighten-4">Данный сервис содержит цифровые товары от тысяч продавцов</p>
                @if ($statistics)
                    {!! $statistics !!}
                @endif
            </div>
            <div class="col l4 s12">
                <h5 class="white-text">Меню</h5>
                <ul>
                    <li>
                        <a href="/?tour=1">Тур по сайту</a>
                    </li>
                    <li>
                        <a href="/how-it-works">Как работает сервис</a>
                    </li>
                    <li>
                        <a href="{{route('catalog')}}">Каталог</a>
                    </li>
                    <li>
                        <a target="_blank" href="https://www.oplata.info/info/?lang=ru-RU">Мои покупки</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <p>© 2016 - {{date('Y')}} SellerStore.ru</p>
            <a href="mailto:admin@sellerstore.ru">Связаться с администратором</a>
        </div>
    </div>
    @if (!empty($footerContent))
        @foreach($footerContent as $item)
            {{$item}}
        @endforeach
    @endif
    {!! setting('site.yandex-metrics') !!}
    {!! setting('site.google-analytics') !!}
</footer>
