<h2 class="seller-goods-title">Отзывы</h2>
@if (!empty($responses))
    <div class="comments" id="comments" data-step="4"
         data-intro="Вы всегда можете прочитать отзывы, которые оставляют другие покупатели именно к выбранному товару.">
        <div class="comments-wrapper" id="comments-wrapper">
            <ul class="pagination"></ul>
            <ul class="list">
                @foreach($responses as $response)
                    <li class="comment {{$response->type_response}}">
                        <div class="comment-date">{{$response->date_response}}</div>
                        <div class="comment-text">{{$response->text_response}}</div>
                        @if (!empty($response->{'comment'}))
                            <div class="comment-response">Ответ продавца: {{$response->comment}}
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif