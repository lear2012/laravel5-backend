webpackJsonp([1],[
/* 0 */,
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function($) {

$(function () {
  var $enroll = $('.enroll');

  if ($enroll.length > 0) {
    var $addr_start = $('#addr_start');
    var $addr_start_label = $addr_start.find('span');
    $addr_start.find('select').on('change', function (event) {
      $addr_start_label.html(this.value);

    });

    var $addr_end = $('#addr_end');
    var $addr_end_label = $addr_end.find('span');
    $addr_end.find('select').on('change', function (event) {
      $addr_end_label.html(this.value);
    });

    var $carry = $('#carry');
    var $carry_label = $carry.find('span');
    $carry.find('select').on('change', function (event) {
      $carry_label.html(this.value);
      $('#carry').val(this.value);
    });

    $('#modal-close').on('click', function (event) {
      $('#modal').hide();
    });

    $('#rules-close').on('click', function (event) {
      $('#rules').hide();
    });
  }
});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(0)))

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function($) {

$(function () {
  var $home = $('.home');

  if ($home.length > 0) {
    var index = 0;
    var arr = ['banner', 'info', 'activity', 'leader', 'comment','about', 'union', 'partner', 'media'];

    var headerHeight = $('header').height();
    var bannerTop, infoTop, activityTop, leaderTop, commentTop, aboutTop, unionTop, partnerTop, mediaTop;

    if ($('#banner').offset()) {
      bannerTop = $('#banner').offset().top;
      infoTop = $('#info').offset().top;
      activityTop = $('#activity').offset().top;
      leaderTop = $('#leader').offset().top;
      commentTop = $('#comment').offset().top;
      aboutTop = $('#about').offset().top;
      unionTop = $('#union').offset().top;
      partnerTop = $('#partner').offset().top;
      mediaTop = $('#media').offset().top;
    }

    $('.icon-top').on('click', function (event) {

      var i = index - 1 > 0 ? index - 1 : 0;

      $.scrollTo('#' + arr[i], 500, {
        offset: -headerHeight
      });

      setTimeout(function () {
        index = i;
      }, 600);
    });

    $('.icon-bottom').on('click', function (event) {

      var i = index + 1 < arr.length ? index + 1 : arr.length;

      $.scrollTo('#' + arr[i], 500, {
        offset: -headerHeight
      });

      setTimeout(function () {
        index = i;
      }, 600);
    });

    $(window).scroll(function () {
      var top = $('body').scrollTop();
      var nav = $('.navigation');

      if (top < infoTop) {
        index = 0;
      } else if (top < activityTop) {
        index = 1;
      } else if (top < leaderTop) {
        index = 2;
      } else if (top < commentTop) {
        index = 3;
      } else if (top < aboutTop) {
        index = 4;
      } else if (top < unionTop) {
        index = 5;
      } else if (top < partnerTop) {
        index = 6;
      } else if (top < mediaTop) {
        index = 7;
      } else {
        index = 8;
      }
        if(top === 0 || ($(window).scrollTop() + $(window).height() === $(document).height())) {
            nav.hide();
        }else {
            nav.show();
        }
    });

    $('#menu').on('click', function (event) {
      $('#bar').show().animate({
        left: '0'
      }, 500);
    });

    var $bar = $('#bar');
    var $bar_nav = $('#bar-nav');
    var $li = $bar_nav.find('li');

    $('#bar-close').on('click', function (event) {
      $bar.animate({
        left: '6.34rem'
      }, 500, function () {
        $bar.hide();
      });
    });

    $bar_nav.on('click', 'li', function () {
      var i = $(this).index();
      var next = 0;

      if (i === 0) {
        next = 1;
      } else if (i === 1) {
        next = 2;
      } else if (i === 2) {
        next = 3;
      } else if (i === 3) {
        next = 4;
      } else if (i === 4) {
        next = 5;
      } else {
        next = 6;
      }

      $li.removeClass('active');
      $(this).addClass('active');

      $bar.animate({
        left: '6.34rem'
      }, 500, function () {
        $bar.hide();
        $.scrollTo('#' + arr[next], 500, {
          offset: -headerHeight
        });

        setTimeout(function () {
          index = next;
        }, 600);
      });
    });
  }

});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(0)))

/***/ }),
/* 3 */,
/* 4 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 5 */,
/* 6 */,
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function($) {

__webpack_require__(3);

__webpack_require__(4);

__webpack_require__(6);

__webpack_require__(2);

__webpack_require__(1);

// import '../node_modules/jquery/dist/jquery.min.js';

$(function () {});
// import './tmpl/index.tmpl.html';
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(0)))

/***/ })
],[7]);
//# sourceMappingURL=main.js.map
