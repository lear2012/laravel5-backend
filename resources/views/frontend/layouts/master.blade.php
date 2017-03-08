<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>会员展示</title>
        <!--设置初始比例（1：1像素还原）-->
        <script>
            var iScale = 1;
            iScale = iScale / window.devicePixelRatio;
            document.write('<meta name="viewport" content="width=device-width,initial-scale=' + iScale + ',minimum-scale=' + iScale + ',maximum-scale=' + iScale + '" />');
            document.getElementsByTagName("html")[0].style.fontSize = document.documentElement.clientWidth / 15 + "px";
        </script>
        <link rel="stylesheet" href="{{ asset('css/all.css', null) }}" />
        @yield('styles')
    </head>
    <body>
    <div id="message"></div>
    @yield('content')
    <script type="text/javascript" src="{{ asset('js/all.js', null) }}"></script>
    @yield('scripts')
    <script src="{{ asset('js/main.js', null) }}"></script>
    </body>
</html>