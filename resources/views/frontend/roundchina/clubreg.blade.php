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

				<p>&nbsp;&nbsp;&nbsp;&nbsp;为了进一步规范可野第一届环中国边境自驾接力活动，丰富业余生活，使每一个参与者的权利、义务、责任得到明确，请参与者仔细阅读本协议内容，资源选择是否参加。凡参与者均视为认同并自愿遵守本协议内容。</p>
				<p>一、本次环中国边境线自驾接力是一个非注册、非经营性的组织，没有任何人是专职的工作人员，活动的发起、联系、组织系北京可野全球自驾主题空间，是为大家提供免费和无偿的服务。是参与者自愿参加与退出、奉献与责任自负的原则上组成的。由于活动为自由组合性质，一旦出现事故，活动中任何非事故当事人将不承担事故任何责任，但有互相援助的义务。活动的组织者应当积极主动的组织实施救援工作，对事故本身不承担任何法律责任和经济责任。</p>
				<p>二、自驾游活动存在很多不可预见的危险，道路行驶、旅游过程、食宿、自身身体健康、自然灾害等等，均有可能造成对自己生命财产的伤害和损失。参与者应当积极主动的购买保险，降低损失。一旦发生事故和人身伤害，由保险公司和自己负责赔偿，不牵扯参与活动的组织者和其他人员。</p>
				<p>三、自驾游一切活动都应该遵守国家相关法律、法规，一切因参加活动者直接或间接引起的法律责任有参加活动者自行独立承担。</p>
				<p>四、自驾游一切活动的车辆、设施以及有关装备属于参加者自己所有，所产生的一切风险及责任也由自己承担所有自驾游活动的参与者应发扬团结互助、助人为乐的精神，在力所能及的范围内尽量给予他人便利和帮助。但任何便利和帮助的给予并不构成法律上的义务，更不构成对其他参与者损失或责任在法律上分担的根据。</p>
				<p>五、自驾游活动会有潜在的危险性，参加者对自己的行为安全负责。凡报名参加者年满18岁者均视为具有完全民事行为能力人，未满18周岁的，由其活动时的监护人负责其全部行为安全。如在活动中发生人身损害后果，组织和参与者不承担赔偿责任，由受害人依据法律规定和本声明依法解决，凡参加者均视为接受本声明。代他人报名者，被代报名参加者如遭受人身损害，赔偿责任组织者和参与者同样不承担。</p>
				<p>六、所有参与者对此次自驾游活动的参与都是完全自愿的，参与者事先对本协议条款的含义及相关法律后果已全部通晓并充分理解。本协议具有法律效力。</p>

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
