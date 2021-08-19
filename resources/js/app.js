let slideWidth = 220;
$(document).on('ready', function () {
    init();
});

function init() {
    $("link[rel*='icon']").each(function(){
        $(this).attr("href", $(this).data('icon'));
    });
    $(".button-collapse").sideNav();
    let $searchDiv = $(".js-search-div");
    let $text = $searchDiv.find('input');
    $searchDiv.find('i').on('click', function () {
        $(this).closest(".search-div").find('input').focus();
    });
    $text.on('change keyup', function () {
        let self = $(this);
        clearTimeout(window.predict);
        window.predict = setTimeout(function () {
            let query = self.val();
            if(query){
                $.ajax({
                    url: '/search/predict/' + query,
                    success: function (msg) {
                        let words = msg;
                        let $listElementHeader = $(".predict-menu > ul");
                        let $listElementPage = $(".predict-menu > div");
                        $listElementHeader.find("li").remove();
                        $listElementPage.find(".prediction").remove();
                        if (words) {
                            for (let i in words) {
                                if (words.hasOwnProperty(i)) {
                                    let word = words[i];
                                    let $liElement = $("<li>").html(word);
                                    let $predictionElement = $("<div>").addClass('prediction orange accent-4').html(word);
                                    $listElementHeader.append($liElement[0]);
                                    $listElementPage.append($predictionElement[0]);
                                }
                            }
                        }
                    }
                });
            }
        }, 300);
    });


    $(".sidebar-wrapper").sticky({topSpacing: 0});
    $(".sort").tablesorter();
    if($("#product-info-table").is("*")){
        let numberOfSlides = Math.ceil($("#product-info-table").width() / slideWidth);
        if($("#product-info-table").width() < slideWidth*2){
            numberOfSlides = 1;
        }
        $('.product-slider').slick({
            infinite: true,
            slidesToShow: numberOfSlides,
            slidesToScroll: numberOfSlides
        });
    }

    if ($("#comments-wrapper").is("*")) {
        let commentList = new List('comments-wrapper', {
            valueNames: ['comment'],
            page: 5,
            pagination: true
        });
    }
    $(".table-review-cell .progress-bar").on('click', function (e) {
        $('html, body').animate({
            scrollTop: $("#comments").offset().top
        }, 1000, 'easeInOutCubic');
    });
    if (getUrlParameter('tour') == '1') {
        $("header").attr({
            "data-step": 1,
            "data-intro": "Это панель управления сайтом."
        });
        $("header .button-collapse").attr({
            "data-step": 2,
            "data-intro": "Здесь вы можете вызвать меню каталога."
        });
        $("#nav-mobile").attr({
            "data-step": 3,
            "data-intro": "Это основное меню сайта. Здесь вы можете изучить, как работает сайт, перейти в каталог и ваши покупки, а также найти нужный вам товар."
        });
    }
    if (getUrlParameter('tour') != undefined) {
        introJs().setOptions({
            nextLabel: "След &rarr;",
            prevLabel: "&larr; Пред",
            skipLabel: "Пропустить",
            doneLabel: "Завершить"
        }).onexit(function () {
            if ($(".main-page_items").is("*")) {
                $(".main-page_items").find('div > a').each(function (i) {
                    $(this).attr('href', $(this).attr('href').replace('?tour=2', ''));
                })
            }
        }).start();
    }

    $('html').click(function(e) {
        if($(e.target).parents('.search-div').length == 0) {
            $('.predict-menu.in-header ul li').each(function (index) {
                $(this).fadeOut(400, function () {
                    $(this).remove();
                })
            })
        }
    });
    $(".search-div > input").on('focus', function () {
        $(this).trigger('change');
    });
    $('.swipebox').swipebox();

    if($(".load-goods").is('*')){
        $.ajax({
            url: window.location.href + "/goods",
            success: function (data) {
                $(".load-goods").html(data);
                $(".goods-table").tablesorter({sortList: [[0]]});
            }
        });
        $.ajax({
            url: window.location.href + "/responses",
            success: function (data) {
                $(".load-responses").html(data);
                let commentList = new List('comments-wrapper', {
                    valueNames: ['comment'],
                    page: 5,
                    pagination: true
                });
            }
        });
    }
}

let getUrlParameter = function getUrlParameter(sParam) {
    let sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};