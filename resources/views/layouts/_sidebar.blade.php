<div class="sidebar-wrapper">
    @if ($sidebar)
        <ul class="sidebar">
            @foreach($sidebar['folder'] as $folder)
                <li class="collection-item">
                    <a href="/category/{{$folder['@attributes']['id']}}"
                       class="dropdown-button btn orange accent-3"
                       data-activates="dropdown{{$folder['@attributes']['id']}}"
                    >
                        @if ($folder['name_folder'] === 'Программное обеспечение')
                            ПО
                        @else
                            {{$folder['name_folder']}}
                        @endif
                        <span class="badge">{{$folder['cnt_goods']}}</span>
                    </a>
                    <ul class="dropdown-content" id="dropdown{{$folder['@attributes']['id']}}">
                        @foreach($folder['folder'] as $x)
                            <li>
                                <a href="/category/{{$x['@attributes']['id']}}">
                                    {{$x['name_folder']}}
                                    <span class="badge">{{$x['cnt_goods']}}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    @endif
    <div class="sidebar-popular">
        <div class="sidebar-popular-title">Популярное</div>
    </div>
    <ul class="sidebar">
        <li class="collection-item">
            <a href="/category/7682" class="dropdown-button btn orange accent-3 active">
                Игры
            </a>
        </li>
    </ul>
</div>
