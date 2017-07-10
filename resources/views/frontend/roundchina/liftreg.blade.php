@extends('frontend.layouts.roundchina')

@section('content')
	<div class="enroll enroll-lift has-header">
		<header>
			<span class="" id="menu"></span>
		</header>

		<div class="navbar">
			<span class="icon-back"></span>
			<span class="icon-person title">选择搭载车辆</span>
		</div>

		<div class="content">

			<div class="search">
				<span class="icon-search"></span>
				<input type="text" id="keyword" name="keyword" />
				<span class="button" id="search_cars">搜索</span>
			</div>
            <div id="car_list">
                @foreach($items as $item)
                <div class="enroll-item" enrollment_id="{{$item->id}}">
                    <p class="item-top">
                        <span>车型：{{$item->brand}}</span>
                        <span>已搭载<b>{{$item->seats_taken}}人</b>/剩余<b>{{(int)$item->available_seats - (int)$item->seats_taken}}人</b></span>
                    </p>
                    <p class="item-bottom">
                        {{$item->start}}<span></span>{{$item->end}}
                    </p>
                </div>
                @endforeach
            </div>
			<p class="more" id="more_cars">点击获取更多<span></span></p>

			<div class="content-bottom">
				<a class="button button-block submit" id="lift_next">下一步</a>
			</div>

		</div>
	</div>


    <div class="enroll enroll-lift-next has-header">
        <header>
            <span class="" id="menu"></span>
        </header>

        <div class="navbar">
            <span class="icon-back lift-back"></span>
            <span class="icon-person title">搭车报名</span>
        </div>

        <div class="content">

            <div class="input-item">
                <input type="text" placeholder="姓名" value="" name="name" id="name" />
            </div>
            <div class="input-item">
                <input type="text" placeholder="联系方式" value="" name="mobile" id="mobile" />
            </div>
            <div class="input-item">
                <input type="text" placeholder="微信号" value="" name="wechat_no" id="wechat_no" />
            </div>

            <div class="agreement">
                <input type="checkbox" value="1" name="agree" id="agree" checked/><a id="reg_rules">阅读并同意活动规则</a>
            </div>

            <div class="button button-block submit" id="liftreg_submit">报名</div>

        </div>
    </div>


	<div class="modal rules" id="rules">
		<div class="modal-wrap">
			<div class="modal-header">
				活动规则
				<span class="icon-close" id="rules-close"></span>
			</div>
			<div class="modal-content">
				<p class="modal-content-title">报名须知</p>
				<p>1、本活动为非营利自助户外活动。属于个人设计的出行日期及路线，仅限同好自愿报名，共同参与。且本次活动为免费活动，期间行程安排需要按照可野全球自驾主题空间制定的时间安排表进行，同时活动过程中如果擅自脱队或者不听从领队人员指挥所产生的任何后果将由本人自行承担。</p>
				<p>2、参与者必须是具有完全民事行为能力的人。一律谢绝未成年人、代替报名及有身体健康问题或有突发病史者。</p>
				<p>3、参与者应该知道户外运动必然有一定的危险性和不可预知性，所以必须自行承担除他人故意造成的人身损害外之全部的安全责任。</p>
				<p>3、参与者应该知道户外运动必然有一定的危险性和不可预知性，所以必须自行承担除他人故意造成的人身损害外之全部的安全责任。</p>
				<p>3、参与者应该知道户外运动必然有一定的危险性和不可预知性，所以必须自行承担除他人故意造成的人身损害外之全部的安全责任。</p>
			</div>
		</div>
	</div>

    <div class="modal" id="lift_modal">
        <div class="modal-wrap">
            <div class="modal-header">
                报名成功
                <span class="icon-close" id="modal-close"></span>
            </div>
            <div class="modal-content">
                <p>&nbsp;&nbsp;&nbsp;&nbsp;我们已收到您的报名信息, 请主动联系车主去搭车。
                以下是您选择的车辆联系人信息, 您可以截屏保存下来</p>
                <div class="info">
                    <div class="info-item">
                        <span class="info-label">姓名：</span>
                        <span class="info-value name"></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">微信号：</span>
                        <span class="info-value wechat_no"></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">联系方式：</span>
                        <span class="info-value mobile"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
