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
        @if(env('APP_ENV') == 'prod')
            <link rel="stylesheet" href="{{ elixir('css/all.css', null) }}" />
        @else
            <link rel="stylesheet" href="{{ asset('css/all.css', null) }}" />
        @endif
        @yield('styles')
    </head>
    <body>
    <div id="message"></div>
    @yield('content')
    @include ('frontend.footer')
    @if(env('APP_ENV') == 'prod')
        <script type="text/javascript" src="{{ elixir('js/all.js', null) }}"></script>
    @else
        <script type="text/javascript" src="{{ asset('js/all.js', null) }}"></script>
    @endif
    @if(isset($js))
    <script type="text/javascript" charset="utf-8">
        wx.config(<?php echo $js->config(array('chooseWXPay'), false); ?>);
    </script>
    @endif
    @yield('scripts')

    </body>
</html>