<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <title>食色性野</title>
    <link rel="stylesheet" href="css/xinj.video.css">
    <script>
        window.onload = window.onresize = function(){
            var deviceWidth = document.documentElement.clientWidth;
            document.documentElement.style.fontSize = deviceWidth/7.5 + 'px';
        };
    </script>
</head>
<body>
@yield('content')
@include ('frontend.footer')
@if(env('APP_ENV') == 'prod')
    <script type="text/javascript" src="{{ elixir('js/xinjvideo.js', null) }}"></script>
@else
    <script type="text/javascript" src="{{ asset('js/xinjvideo.js', null) }}"></script>
@endif
@if(isset($js))
    <script type="text/javascript" charset="utf-8">
        wx.config(<?php echo $js->config(array('onMenuShareTimeline', 'onMenuShareAppMessage','onMenuShareQQ', 'onMenuShareWeibo')); ?>);
        wx.ready(function() {
            // 分享给朋友
            wx.onMenuShareAppMessage({
                title: "食色性野 \n可野环中国新疆段视频集锦", //
                desc: '可野环中国新疆段视频集锦', //
                link: 'http://keye.liaollisonest.com/xinjvideo', //
                imgUrl: 'http://keye.liaollisonest.com/images/xinjiang/xinjiang_share.jpg', // 分享的图标
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
            // 分享到朋友圈
            wx.onMenuShareTimeline({
                title: "食色性野 \n可野环中国新疆段视频集锦", //
                desc: '可野环中国新疆段视频集锦', //
                link: 'http://keye.liaollisonest.com/xinjvideo', //
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
