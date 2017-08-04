<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
    <meta name="format-detection" content="telephone=no"/>
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <title>@yield('title')</title>
    @if(env('APP_ENV') == 'prod')
        <link rel="stylesheet" href="{{ elixir('css/xinjiang-final.css', null) }}" />
    @else
        <link rel="stylesheet" href="{{ asset('css/xinjiang-final.css', null) }}" />
    @endif
    @yield('styles')
    <script type="text/javascript">
        window.onresize = function() {
            document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px';
        };
        window.onresize();
        // humane.timeout = 2000;
    </script>
</head>
<body>
@yield('content')
@include ('frontend.footer')
@if(env('APP_ENV') == 'prod')
    <script type="text/javascript" src="{{ elixir('js/xinjiang-final.js', null) }}"></script>
@else
    <script type="text/javascript" src="{{ asset('js/xinjiang-final.js', null) }}"></script>
@endif
@if(isset($js))
    <script type="text/javascript" charset="utf-8">
        wx.config(<?php echo $js->config(array('onMenuShareTimeline', 'onMenuShareAppMessage','onMenuShareQQ', 'onMenuShareWeibo')); ?>);
        wx.ready(function() {
            // 分享给朋友
            wx.onMenuShareAppMessage({
                title: "食色性野 你敢来么？\n这时间，唯美食与风景不可辜负", //
                desc: '食色性野 你敢来么？', //
                link: 'http://keye.liaollisonest.com/xinjiang', //
                imgUrl: 'http://keye.liaollisonest.com/images/xinjiang/xinjiang_share.jpg', // 分享的图标
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
            // 分享到朋友圈
            wx.onMenuShareTimeline({
                title: "食色性野 你敢来么？\n这时间，唯美食与风景不可辜负", //
                desc: '食色性野 你敢来么？', //
                link: 'http://keye.liaollisonest.com/xinjiang', //
                imgUrl: 'http://keye.liaollisonest.com/images/xinjiang/xinjiang_share.jpg', // 分享的图标
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
        });

    </script>
@endif
@yield('scripts')

</body>
</html>
