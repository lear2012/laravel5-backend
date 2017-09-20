@extends('frontend.layouts.xinjvideo')
@section('styles')

@endsection
@section('content')
    <header class="clearfix">
        <div class="logo">
            <img src="img/keye.png" alt="可野">
        </div>
        <div class="wenzi">
            <img src="img/wenzi.png" alt="新疆食色之旅">
        </div>
    </header>
    <div class="content">
        <div class="wrapper">
            <video class="video" preload="none" poster="images/xinzang/1.png">
                <source src="video/101.mp4" type="video/mp4">
            </video>
            <div class="playpause"></div>
            <p>绝不辜负那些在路上的美好时光</p>
        </div>
        <div class="wrapper">
            <video class="video" preload="none" poster="images/xinzang/2.png">
                <source src="video/102.mp4" type="video/mp4">
            </video>
            <div class="playpause"></div>
            <p>欧加拉，微笑是世界上最美的语言</p>
        </div>
        <div class="wrapper">
            <video class="video" preload="none" poster="images/xinzang/3.png">
                <source src="video/103.mp4" type="video/mp4">
            </video>
            <div class="playpause"></div>
            <p>可野环中国新疆段“食色之旅”维吾尔族美女跳舞</p>
        </div>
        <div class="wrapper">
            <video class="video" preload="none" poster="images/xinzang/4.png">
                <source src="video/104.mp4" type="video/mp4">
            </video>
            <div class="playpause"></div>
            <p>惊！可野环中国车队竟然和新疆美女做这个！</p>
        </div>

        <footer>
            已加载全部视频
        </footer>
    </div>
@endsection
