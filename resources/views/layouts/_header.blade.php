<header>
    <nav class="orange accent-4">
        <div class="nav-wrapper">
            <a href="#" data-activates="mobile-side-menu" class="button-collapse">
                <i class="material-icons">menu</i>
            </a>
            <a href="/" class="brand-logo">
                <img class="main-logo" src="/images/logo.png" alt="">
            </a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li>
                    <a href="/sections">Каталог</a>
                </li>
                <li>
                    <a href="/?tour=1">Тур по сайту</a>
                </li>
                <li>
                    <a href="/how-it-works">Как работает сервис</a>
                </li>
                <li>
                    <a href="/how-to-pay">Оплата</a>
                </li>
                <li>
                    <a href="https://www.oplata.info/info/?lang=ru-RU" target="_blank">Мои покупки</a>
                </li>
                <li>
                    <div class="nav-wrapper">
                        <form action="/search" method="get">
                            <div class="input-field search-div">
                                <input name="q" type="search" required="required" value="{{$q}}" class="validate" id="q"/>
                                <label for="search">
                                    <i class="material-icons">search</i>
                                </label>
                                <div class="predict-menu">
                                    <ul class="orange accent-4"></ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
            </ul>
            <a href="/search" class="mobile-search-button show-on-small show-on-mid hide-on-large-only">
                <i class="material-icons">search</i>
            </a>
            <ul class="side-nav" id="mobile-side-menu">
                @foreach($sidebar as $item)
                    <li>
                        <a href="/category/{{$folder['id']}}" class="dropdown-button" data-activates="dropdown{{$folder['id']}}">
                            @if ($folder['name_folder'] === 'Программное обеспечение')
                                ПО
                            @else
                                {{$folder['name_folder']}}
                            @endif
                        </a>
                        <span class="badge">{{$folder['cnt_goods']}}</span>
                        <ul class="dropdown-content" id="dropdown{{$folder['id']}}">
                            @foreach($folder['folder'] as $x)
                                <li>
                                    <a href="/category/{{$x['id']}}">
                                        | {{$x['name_folder']}}
                                        <span class="badge">{{$x['cnt_goods']}}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
</header>
