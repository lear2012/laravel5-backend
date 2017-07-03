@extends('backend.layouts.master')

@section('title', 'TEST')

@section('styles')

@endsection

@section('breadcrumb')
    <li>
        <i class="ace-icon fa fa-home home-icon"></i>
        <a href="/admin/dashboard">主页</a>
    </li>
    <li>
        <a>TEST</a>
    </li>
    <li>
        TEST
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">TEST</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <button class="icobutton icobutton-thumbs-up"><span class="fa fa-thumbs-up"></span></button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            var myTimeline = new mojs.Timeline();
            var scaleCurve = mojs.easing.path('M0,100 L25,99.9999983 C26.2328835,75.0708847 19.7847843,0 100,0');

            var myAnimation1 = new mojs.Burst({
                duration: 1500,
                shape : 'circle',
                top: 0,
                left: 0,
                opacity: 0.8,
                childOptions: {
                    radius: {5:0},
                },
                children: {
                    fill: [ '#988ADE', '#DE8AA0', '#8AAEDE', '#8ADEAD', '#DEC58A', '#8AD1DE' ],
                },
                radius: {30:50},
                angle: {0: 180},
                count: 6,
                isSwirl: true,
                isRunLess: true,
            });

            var myAnimation2 = new mojs.Transit({
                duration: 750,
                type: 'circle',
                radius: {0: 25},
                fill: 'transparent',
                top: 0,
                left: 0,
                stroke: '#f6d107',
                strokeWidth: {4:0},
                opacity: 0.6,
                isRunLess: true,
            });

            myTimeline.add(myAnimation1, myAnimation2);

            $(".icobutton-thumbs-up").on('click',function() {
                playBurst(this);
                return true;
            });

            function playBurst(that) {
                var elSpan = that.querySelector('span');
                var aniPos = findCenter($(that));
                myAnimation1.tune({ top: aniPos.y, left: aniPos.x });
                myAnimation2.tune({ top: aniPos.y, left: aniPos.x });
                myTimeline.replay();

                new mojs.Tween({
                    duration : 600,
                    onUpdate: function(progress) {
                        if(progress > 0.3) {
                            var scaleProgress = scaleCurve(progress);
                            elSpan.style.WebkitTransform = elSpan.style.transform = 'scale3d(' + scaleProgress + ',' + scaleProgress + ',1)';
                            elSpan.style.WebkitTransform = elSpan.style.color = '#f6d107';
                        } else {
                            elSpan.style.WebkitTransform = elSpan.style.transform = 'scale3d(0,0,1)';
                            elSpan.style.WebkitTransform = elSpan.style.color = '#f6d107';
                        }
                    },
                    onComplete (isForward, isYoyo) {
                        $( "body" ).click(function( event ) {
                            if(event.target.nodeName == 'ellipse')
                                myTimeline.replay();
                        });
                    },
                }).play();
            }

            function findCenter ($this) {
                var offset = $this.offset();
                var width = $this.width();
                var height = $this.height();
                var Pos = {
                    x: offset.left + (width / 2),
                    y: offset.top + (height / 2)
                };
                return Pos;
            }
        });
    </script>
@endsection

