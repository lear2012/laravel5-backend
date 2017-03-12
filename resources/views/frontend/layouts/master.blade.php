<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <!--设置初始比例（1：1像素还原）-->
        <script>
            var iScale = 1;
            iScale = iScale / window.devicePixelRatio;
            document.write('<meta name="viewport" content="width=device-width,initial-scale=' + iScale + ',minimum-scale=' + iScale + ',maximum-scale=' + iScale + '" />');
            document.getElementsByTagName("html")[0].style.fontSize = document.documentElement.clientWidth / 15 + "px";
        </script>
        <link rel="stylesheet" href="{{ elixir('css/all.css', null) }}" />
        @yield('styles')
    </head>
    <body>
    <div id="message"></div>
    @yield('content')

    <script type="text/javascript" src="{{ elixir('js/all.js', null) }}"></script>
    @yield('scripts')
    {{--<script src="{{ elixir('js/main.js', null) }}"></script>--}}
    @include ('frontend.footer')

    </body>
</html>