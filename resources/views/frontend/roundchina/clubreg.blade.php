@extends('frontend.layouts.roundchina')

@section('content')
	<div class="enroll has-header">
		<header>
			<span class="" id="menu"></span>
		</header>

		<div class="navbar">
			<span class="icon-back"></span>
			<span class="icon-club title">俱乐部报名</span>
		</div>

		<div class="content">
			<div class="input-item">
				<input type="text" placeholder="俱乐部名称" value="" name="club_name" id="club_name">
			</div>
			<div class="input-item">
				<input type="text" placeholder="联系人" value="" name="name" id="name">
			</div>
			<div class="input-item">
				<input type="text" placeholder="联系方式" value="" name="mobile" id="mobile">
			</div>

			<div class="agreement">
                <input type="checkbox" value="1" name="agree" id="agree" checked/><a id="reg_rules">阅读并同意活动规则</a>
			</div>

			<div class="button button-block submit" id="clubreg_submit">报名</div>

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

	<div class="modal" id="modal">
		<div class="modal-wrap">
			<div class="modal-header">
				报名成功
				<span class="icon-close" id="modal-close"></span>
			</div>
			<div class="modal-content">
				<p>我們已收到您的报名信息</p>
				<p>后续会有工作人员与您联系</p>
				<p>感谢您的合作</p>
			</div>
		</div>
	</div>


@endsection
