@extends('frontend.layouts.roundchina')

@section('content')
	<div class="enroll enroll-lift has-header">
		<header>
			<span class="" id="menu"></span>
		</header>

		<div class="navbar">
			<span class="icon-back"></span>
			<span class="icon-people title">自驾报名名单</span>
		</div>

		<div class="content">

            <div id="car_list">
                @if(count($items) > 0)
                @foreach($items as $item)
                <div class="enroll-item" enrollment_id="{{$item->id}}">
                    <p class="item-top">
                        <span>车型：{{$item->brand}}</span>
                        @if($item->available_seats > 0)
                        <span>已搭载<b>{{$item->seats_taken}}人</b>/剩余<b>{{((int)$item->available_seats - (int)$item->seats_taken) > 0 ? (int)$item->available_seats - (int)$item->seats_taken : 0}}人</b></span>
                        @endif
                    </p>
                    <p class="item-bottom">
                        {{$item->start}}<span></span>{{$item->end}}
                    </p>
                </div>
                @endforeach
                @else
                    <span class="notice-msg">目前没有可供搭载的车辆，敬请期待！</span>
                @endif
            </div>
            @if(count($items) > 0)
			<p class="more" id="more_selfreg_cars">点击获取更多<span></span></p>
            @endif

		</div>
	</div>
@endsection
