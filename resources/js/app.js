//main
var slideWidth = 220;
// document.addEventListener("turbolinks:request-start", function(event) {
//     $("link[rel*='icon']").each(function(){
//         $(this).data('icon', $(this).attr("href")).attr("href", "/images/ring.gif");
//     });
// });
$(document).on('ready turbolinks:load', function () {
    init();
});

function init() {
    $("link[rel*='icon']").each(function(){
        $(this).attr("href", $(this).data('icon'));
    });
    $(".button-collapse").sideNav();
    var $searchDiv = $(".search-div");
    var $text = $searchDiv.find('input');
    $searchDiv.find('i').on('click', function () {
        $(this).closest(".search-div").find('input').focus();
    });
    $text.on('change keyup', function () {
        var self = $(this);
        clearTimeout(window.predict);
        window.predict = setTimeout(function () {
            var query = self.val();
            if(query){
                $.ajax({
                    url: '/search/predict/' + query,
                    success: function (msg) {
                        var words = msg;
                        var $listElement = $(".predict-menu > ul");
                        $listElement.find("li").remove();
                        if (words) {
                            for (var i in words) {
                                if (words.hasOwnProperty(i)) {
                                    var word = words[i];
                                    var $liElement = $("<li>").html(word);
                                    $listElement.append($liElement[0]);
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
        var numberOfSlides = Math.ceil($("#product-info-table").width() / slideWidth);
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
        var commentList = new List('comments-wrapper', {
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
            $('.predict-menu ul li').each(function (index) {
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
                var commentList = new List('comments-wrapper', {
                    valueNames: ['comment'],
                    page: 5,
                    pagination: true
                });
            }
        });
    }
}

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
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
//main



//products page
$(function () {
    $(".card-action > form").on('submit', function () {
        yaCounter36646980.reachGoal('button-buy');
    });
});
//products page