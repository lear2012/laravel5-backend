<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>会员展示</title>
        <!--设置初始比例（1：1像素还原）-->
        <script>
            var iScale = 1;
            iScale = iScale / window.devicePixelRatio;
            document.write('<meta name="viewport" content="width=device-width,initial-scale=' + iScale + ',minimum-scale=' + iScale + ',maximum-scale=' + iScale + '" />');
            document.getElementsByTagName("html")[0].style.fontSize = document.documentElement.clientWidth / 15 + "px";
        </script>
        <link rel="stylesheet" href="{{ asset('css/reset.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/homepage.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/swiper.min.css') }}">
        @yield('styles')
    </head>
    <body>
    @yield('content')
    <script type="text/javascript" src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/url.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
    @yield('scripts')
    </body>
</html>