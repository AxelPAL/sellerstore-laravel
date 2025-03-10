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
                    <a href="{{route('catalog')}}">Каталог</a>
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
                            <div class="input-field search-div js-search-div">
                                <input name="q" type="search" required="required" value="{{$q}}" class="validate"
                                       id="q"/>
                                <label for="search">
                                    <i class="material-icons">search</i>
                                </label>
                                <div class="predict-menu in-header">
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
                @if(isset($sidebar['folder']))
                    @foreach($sidebar['folder'] as $folder)
                        <li>
                            <a href="/category/{{$folder['@attributes']['id']}}" class="dropdown-button"
                               data-activates="dropdown{{$folder['@attributes']['id']}}">
                                @if ($folder['name_folder'] === 'Программное обеспечение')
                                    ПО
                                @else
                                    {{$folder['name_folder']}}
                                @endif
                            </a>
                            <span class="badge">{{$folder['cnt_goods']}}</span>
                            <ul class="dropdown-content" id="dropdown{{$folder['@attributes']['id']}}">
                                @if (!empty($folder['folder']))
                                    @foreach($folder['folder'] as $x)
                                        <li>
                                            <a href="/category/{{$x['@attributes']['id']}}">
                                                | {{$x['name_folder']}}
                                                <span class="badge">{{$x['cnt_goods']}}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </nav>
</header>
