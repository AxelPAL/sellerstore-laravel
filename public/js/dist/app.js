/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/materialize-css/sass/materialize.scss":
/*!************************************************************!*\
  !*** ./node_modules/materialize-css/sass/materialize.scss ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./node_modules/slick-carousel/slick/slick-theme.scss":
/*!************************************************************!*\
  !*** ./node_modules/slick-carousel/slick/slick-theme.scss ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./node_modules/slick-carousel/slick/slick.scss":
/*!******************************************************!*\
  !*** ./node_modules/slick-carousel/slick/slick.scss ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

//main
var slideWidth = 220; // document.addEventListener("turbolinks:request-start", function(event) {
//     $("link[rel*='icon']").each(function(){
//         $(this).data('icon', $(this).attr("href")).attr("href", "/images/ring.gif");
//     });
// });

$(document).on('ready turbolinks:load', function () {
  init();
});

function init() {
  $("link[rel*='icon']").each(function () {
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

      if (query) {
        $.ajax({
          url: '/search/predict/' + query,
          success: function success(msg) {
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
  $(".sidebar-wrapper").sticky({
    topSpacing: 0
  });
  $(".sort").tablesorter();

  if ($("#product-info-table").is("*")) {
    var numberOfSlides = Math.ceil($("#product-info-table").width() / slideWidth);

    if ($("#product-info-table").width() < slideWidth * 2) {
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
      plugins: [ListPagination({})]
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
        });
      }
    }).start();
  }

  $('html').click(function (e) {
    if ($(e.target).parents('.search-div').length == 0) {
      $('.predict-menu ul li').each(function (index) {
        $(this).fadeOut(400, function () {
          $(this).remove();
        });
      });
    }
  });
  $(".search-div > input").on('focus', function () {
    $(this).trigger('change');
  });
  $('.swipebox').swipebox();
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
}; //main
//products page


$(function () {
  $(".card-action > form").on('submit', function () {
    yaCounter36646980.reachGoal('button-buy');
  });
}); //products page

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** multi ./resources/js/app.js ./node_modules/materialize-css/sass/materialize.scss ./node_modules/slick-carousel/slick/slick.scss ./node_modules/slick-carousel/slick/slick-theme.scss ./resources/sass/app.scss ***!
  \**********************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /c/www/sellerstore-laravel/resources/js/app.js */"./resources/js/app.js");
__webpack_require__(/*! /c/www/sellerstore-laravel/node_modules/materialize-css/sass/materialize.scss */"./node_modules/materialize-css/sass/materialize.scss");
__webpack_require__(/*! /c/www/sellerstore-laravel/node_modules/slick-carousel/slick/slick.scss */"./node_modules/slick-carousel/slick/slick.scss");
__webpack_require__(/*! /c/www/sellerstore-laravel/node_modules/slick-carousel/slick/slick-theme.scss */"./node_modules/slick-carousel/slick/slick-theme.scss");
module.exports = __webpack_require__(/*! /c/www/sellerstore-laravel/resources/sass/app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });