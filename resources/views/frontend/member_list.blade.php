@extends('frontend.layouts.master')

@section('styles')
@endsection
@section('content')
<header>
    <h2>老司机</h2>
    <div class="swiper-container">
        <i class="swiper-button-next"></i>
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="img/avatar.png" class="main-img"></div>
            <div class="swiper-slide"><img src="img/avatar2.png" class="main-img"></div>
            <div class="swiper-slide"><img src="img/avatar3.png" class="main-img"></div>
            <div class="swiper-slide"><img src="img/avatar4.png" class="main-img"></div>
            <div class="swiper-slide"><img src="img/avatar5.png" class="main-img"></div>
            <div class="swiper-slide"><img src="img/avatar3.png" class="main-img"></div>
        </div>
        <i class="swiper-button-prev"></i>
    </div>
    <div class="info">
        <p class="name">

        </p>
        <div class="Age-job">
            <span class="job">121232</span>
            <span class="age">13213123</span>
        </div>
        <p class="autograph">

        </p>
    </div>
</header>

<section>
    <h2>可野人</h2>
    <ul class="user-list">
        <li>
            <img src="img/f746272283fbfc990e6c24f75fe3d917bf36f6cd30f55-4Pvaxw_fw658.jpg" />
            <p>Mattfuck</p>
            <span>1可野龄</span>
        </li>
        <li>
            <img src="img/f746272283fbfc990e6c24f75fe3d917bf36f6cd30f55-4Pvaxw_fw658.jpg" />
            <p>Mattfuck</p>
            <span>1可野龄</span>
        </li>
        <li>
            <img src="img/f746272283fbfc990e6c24f75fe3d917bf36f6cd30f55-4Pvaxw_fw658.jpg" />
            <p>Mattfuck</p>
            <span>1可野龄</span>
        </li>
        <li>
            <img src="img/f746272283fbfc990e6c24f75fe3d917bf36f6cd30f55-4Pvaxw_fw658.jpg" />
            <p>Mattfuck</p>
            <span>1可野龄</span>
        </li>
        <li>
            <img src="img/f746272283fbfc990e6c24f75fe3d917bf36f6cd30f55-4Pvaxw_fw658.jpg" />
            <p>Mattfuck</p>
            <span>1可野龄</span>
        </li>
        <li>
            <img src="img/f746272283fbfc990e6c24f75fe3d917bf36f6cd30f55-4Pvaxw_fw658.jpg" />
            <p>Mattfuck</p>
            <span>1可野龄</span>
        </li>
    </ul>
</section>

<footer>

</footer>
@endsection
@section('scripts')
    <script src="{{ asset('js/swiper.min.js') }}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        var arr = [
            {
                'name':'Tom1',
                'Age':'34',
                'job':'自由自业者',
                'autograph':'1234'
            },
            {
                'name':'Tom2',
                'Age':'34',
                'job':'自由自业者',
                'autograph':'2234'
            },
            {
                'name':'Tom3',
                'Age':'34',
                'job':'自由自业者',
                'autograph':'3234'
            },
            {
                'name':'Tom4',
                'Age':'34',
                'job':'自由自业者',
                'autograph':'4234'
            },
            {
                'name':'Tom5',
                'Age':'34',
                'job':'自由自业者',
                'autograph':'5234'
            },
            {
                'name':'Tom6',
                'Age':'34',
                'job':'自由自业者',
                'autograph':'6234'
            }
        ];
        var mySwiper = new Swiper(".swiper-container", {
            slidesPerView: 3,
            centeredSlides: !0,
//			initialSlide :1,
            autoplayDisableOnInteraction : false,
            coverflow: {
                rotate: 30,
                stretch: 10,
                depth: 60,
                modifier: 2,
                slideShadows: true
            },
            loop: true,

            watchSlidesProgress: !0,
            pagination: ".swiper-pagination",
            paginationClickable: !0,
            prevButton:'.swiper-button-prev',
            nextButton:'.swiper-button-next',
            onProgress: function(swiper){
                for (var i = 0; i < swiper.slides.length; i++){
                    var slide = swiper.slides[i];
                    var progress = slide.progress;
                    scale = 1 - Math.min(Math.abs(progress * 0.2), 1);
                    es = slide.style;
                    es.opacity = 1 - Math.min(Math.abs(progress/2),1);
                    es.webkitTransform = es.MsTransform = es.msTransform = es.MozTransform = es.OTransform = es.transform = 'translate3d(0px,0,'+(-Math.abs(progress*150))+'px)';

                }
            },

            onSetTransition: function(swiper, speed) {

                for (var i = 0; i < swiper.slides.length; i++) {
                    es = swiper.slides[i].style;
                    es.webkitTransitionDuration = es.MsTransitionDuration = es.msTransitionDuration = es.MozTransitionDuration = es.OTransitionDuration = es.transitionDuration = speed + 'ms';
                }
//				console.log(swiper.activeIndex)
            }
        });
        function infoHtml(i){
            $('.info .name').text(arr[i].name);
            $('.info .autograph').text(arr[i].autograph);
            $('.info .Age-job .age').text(arr[i].Age);
            $('.info .Age-job .job').text(arr[i].job);
        }
    </script>
@endsection