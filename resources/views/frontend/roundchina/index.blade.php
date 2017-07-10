@extends('frontend.layouts.roundchina')

@section('content')
	<div class="home has-header">
		<header>
			<span class="menu" id="menu"></span>
		</header>

		<section class="banner" id="banner">
			<div class="slide">
				<img src="images/roundchina/banner-1@2x.png" alt="">
			</div>
		</section>

		<section class="routes">

			<p class="title">已有<span>193</span>人报名活动</p>
			<p class="title">
				<b class="icon-fire"></b>
				已有<span>208</span>人为活动围观点赞
				<b class="icon-fire"></b>
			</p>
			<div class="buttons">
				<a class="button" href="roundchina/selfreg">自驾报名</a>
				<a class="button" href="roundchina/liftreg">搭车报名</a>
				<a class="button" href="roundchina/clubreg">俱乐部报名</a>
			</div>
			<img class="map" src="images/roundchina/map@2x.png" alt="">

			<div class="route">

				<!-- 西线 -->
				<div class="route-item active">
					<div class="route-header">
						<p class="route-title">西线正在进行中：</p>
						<p class="route-city">
							<span>浩特</span>
							<b class="icon-car"></b>
							<span>西双版纳</span>
						</p>
						<p>
							<span>07月15日</span>
							<b class="icon-line">—</b>
							<span>08月18日</span>
						</p>
					</div>
					<p class="route-subtitle">以下为西线6段线路</p>

					<!-- 线路 -->
					<div class="item">
						<p class="item-title">内蒙段<span class="icon-like"></span></p>
						<p>浩特-西双版纳</p>
					</div>
					<div class="item">
						<p class="item-title">内蒙段<span class="icon-like-active"></span></p>
						<p>浩特-西双版纳</p>
					</div>
					<div class="item">
						<p class="item-title">内蒙段<span class="icon-like"></span></p>
						<p>浩特-西双版纳</p>
					</div>

				</div>

				<!-- 东线 -->
				<div class="route-item">
					<div class="route-header">
						<p class="route-title">东线尚未开始：</p>
						<p class="route-city">
							<span>浩特</span>
							<b class="icon-car"></b>
							<span>西双版纳</span>
						</p>
						<p>
							<span>07月15日</span>
							<b class="icon-line">—</b>
							<span>08月18日</span>
						</p>
					</div>
					<p class="route-subtitle">以下为东线6段线路</p>

					<!-- 线路 -->
					<div class="item">
						<p class="item-title">内蒙段<span class="icon-like"></span></p>
						<p>浩特-西双版纳</p>
					</div>
					<div class="item">
						<p class="item-title">内蒙段<span class="icon-like-active"></span></p>
						<p>浩特-西双版纳</p>
					</div>
					<div class="item">
						<p class="item-title">内蒙段<span class="icon-like"></span></p>
						<p>浩特-西双版纳</p>
					</div>

				</div>
			</div>
		</section>

		<!-- 活动介绍 -->
		<section class="section info" id="info">
			<div class="section-header header-info"></div>
			<img src="images/roundchina/info-1@2x.png" alt="">
			<p>用轮胎的印记来丈量祖国完整边境公路, 历时<b>61天</b>，<b>4万</b>公里，<b>300多处</b>美景，<b>30个</b>车友俱乐部<b>1000名</b>自驾车主。随地随时， 随心所遇， 随队逐行。不必担心时间 ，2个月的旅程， 随时都可以加入。不必担心地点 ，放开所有顾虑 ，2万公里的游历。不管有没有车，哪里都可以启程。根据车辆情况拼车，超百万人关注。</p>
			<div class="imgs">
				<img src="images/roundchina/info-2@2x.png" alt="">
				<img src="images/roundchina/info-3@2x.png" alt="">
			</div>
			<p class="section-subtitle b">我们会沿国家边境线行进，本次行程共分为两段以及十二条线路</p>
			<p><b>前半段—西线：</b>7月15日开始，8月18日结束起点为二连浩特、终点为西双版纳共分为以下几段行程：内蒙段-7月15日-7月19日,北疆段-7月20日-7月26日,南疆段-7月27日-7月30日,新藏段-7月31日-8月04日,后藏段-8月05日-8月10日,滇藏段-8月11日-8月18日。</p>
			<div class="imgs">
				<img src="images/roundchina/info-4@2x.png" alt="">
				<img src="images/roundchina/info-5@2x.png" alt="">
			</div>
			<p><b>后半段—东线：</b>12月15日开始，1月14日结束 起点为西双版纳、终点为二连浩特共分为以下几段行程：云南段-12月15日-12月22日,中越沿边公路段-12月23日-12月26日,东南沿海段-12月27日-01月02日,东部沿海段-1月03日-1月05日,东北地区段-1月06日-1月8日,呼伦贝尔段-1月09日-1月14日。</p>
			<img src="images/roundchina/info-6@2x.png" alt="">
			<p>参与者每完成一段线路，便可获得一枚与属线路勋章。完成全部线路，还可获得与属环中国边境线纪念铜板。</p>
			<img src="images/roundchina/info-7@2x.png" alt="">
			<p class="section-subtitle"><b>全形地貌 视觉冲击</b></p>
			<p>丹霞地貌、喀斯特地貌、雅丹地貌、海岸地貌、风积地貌、风蚀地貌、河流地貌、冰川地貌...</p>
			<img src="images/roundchina/info-8@2x.png" alt="">
			<p class="section-subtitle"><b>各地人文 思想升华</b></p>
			<p>天山文化、藏区文化、大漠文化、西域文化、三秦文化、滇黔文化、南岭文化、 闽南文化...</p>
		</section>

		<!-- 公益活动 -->
		<section class="section activity" id="activity">
			<div class="section-header header-activity"></div>
			<img src="images/roundchina/activity-1@2x.png" alt="">
			<p>整个活劢期间,车队将造访6家贫困小学、拜访6家老人院 为孩子和老人送去所有关注环中国车友的关怀。</p>
			<div class="imgs">
				<img src="images/roundchina/activity-2@2x.png" alt="">
				<img src="images/roundchina/activity-3@2x.png" alt="">
			</div>
			<p>活劢期间的接力仪式及公益活劢会根据情况邀请明星“<b>青年演员任宇</b>”“<b>痛仰乐队主唱高虎</b>”等相关公众人物参与。</p>
		</section>

		<!-- 领队介绍 -->
		<section class="section leader" id="leader">
			<div class="section-header header-leader"></div>
            <img src="images/roundchina/leader-2@2x.png" alt="">
            <p>此次活动由可野老司机玉儿亲自带队</p>
            <p><b>她是越野界的老炮</b></p>
            <p><b>2005年她单车上路80万里10余年的越野经历</b></p>
            <p>她俨然已成为一位经验丰富的女司机</p>
            <p>冰川雪地、荒漠戈壁、她都能带你肆意驰骋</p>
			<img src="images/roundchina/leader-1@2x.png" alt="">
			<p class="left">《越野十年》作家、英国认证陆虎体系教官—<b>玉儿</b></p>
			<p>环中国自驾第1人—<b>李峰</b></p>
			<p>冠军赛车手—<b>韩魏</b></p>
			<p>自驾地理创始人—<b>老迈狼</b></p>
			<p>知名摄影家、旅行家—<b>姜曦</b></p>
			<p>他们是一群不被“<b>应该</b>”束缚</p>
			<p>在路上勇敢追寻自己的梦想的<b>老司机</b></p>

		</section>

		<!-- 关于可野 -->
		<section class="section about" id="about">
			<div class="section-header header-about"></div>
			<img src="images/roundchina/about-1@2x.png" alt="">
			<p><b>生活可以野一点！可以越野。</b>中国唯一提供专业自驾越野解决方案、越野自驾活动组织管理、自驾越野社群综合维护与管理的线上+线下平台。</p>
			<div class="imgs">
				<img src="images/roundchina/about-2@2x.png" alt="">
				<img src="images/roundchina/about-3@2x.png" alt="">
			</div>
			<p>该平台以自驾越野领域KOL为核心，通过线上带动线下的社群组织方式，为会员提供独特的自驾越野会员服务，分享精彩原创游记、区域路线及自驾产品、专业路书攻略、全国联合基地服务等。吸引了大量有车一族的加入。</p>
		</section>

		<!-- 可野自驾联盟 -->
		<section class="section union" id="union">
			<div class="section-header header-union"></div>
			<div class="groups">
				<img src="images/roundchina/union-1@2x.png" alt="">
				<img src="images/roundchina/union-2@2x.png" alt="">
				<img src="images/roundchina/union-3@2x.png" alt="">
				<img src="images/roundchina/union-4@2x.png" alt="">
				<img src="images/roundchina/union-5@2x.png" alt="">
				<img src="images/roundchina/union-6@2x.png" alt="">
				<img src="images/roundchina/union-7@2x.png" alt="">
				<img src="images/roundchina/partner-3@2x.png" alt="">
                <img src="images/roundchina/kanlu.png" alt="">
			</div>
		</section>

		<!-- 合作品牌 -->
		<section class="section partner" id="partner">
			<div class="section-header header-partner"></div>
			<div class="groups">
				<img src="images/roundchina/partner-4@2x.png" alt="" class="special">
				<img src="images/roundchina/partner-1@2x.png" alt="">
				<img src="images/roundchina/partner-2@2x.png" alt="">


			</div>
		</section>

		<!-- 合作媒体 -->
		<section class="section media" id="media">
			<div class="section-header header-media"></div>
			<div class="groups">
				<img src="images/roundchina/media-1@2x.png" alt="">
				<img src="images/roundchina/media-2@2x.png" alt="">
			</div>
		</section>

		<footer>
			<p class="footer-line1">全程直播<span class="icon-media"></span>推进</p>
			<p class="footer-line2">每段路程 . 每次接力 . 每场活动全程直播</p>
			<div class="media-groups">
				<div class="media-item">
					<img src="images/roundchina/icon-media-1@2x.png" alt="">
					<p>可野</p>
					<p>微信公众号</p>
				</div>
				<div class="media-item">
					<img src="images/roundchina/icon-media-2@2x.png" alt="">
					<p>可野</p>
					<p>官方微博</p>
				</div>
				<div class="media-item">
					<img src="images/roundchina/icon-media-3@2x.png" alt="">
					<p>可野</p>
					<p>头条号</p>
				</div>
				<div class="media-item">
					<img src="images/roundchina/icon-media-4@2x.png" alt="">
					<p>可野</p>
					<p>直播号</p>
				</div>
				<div class="media-item">
					<img src="images/roundchina/icon-media-5@2x.png" alt="">
					<p>可野</p>
					<p>优酷自媒体</p>
				</div>
			</div>

			<div class="footer-bottom">
				<img src="images/roundchina/code@2x.png" alt="">
				<p>
					<span class="name">庆江</span>
					<span class="icon-mobile"></span>
					<span>电话：13810053040</span>
				</p>
				<p>
					<span class="name"></span>
					<span class="icon-wechat"></span>
					<span>微信：qingjiang</span>
				</p>
				<p>
					<span class="name">马腾</span>
					<span class="icon-mobile"></span>
					<span>电话：13920225633</span>
				</p>
				<p>
					<span class="name"></span>
					<span class="icon-wechat"></span>
					<span>微信：ikari33</span>
				</p>
			</div>
		</footer>
	</div>

	<div class="rightBar" id="bar">
		<span class="bar-close" id="bar-close"></span>
		<div class="bar-content">
			<div class="bar-header">
				<span>环中国活动导航</span>
			</div>
			<ul id="bar-nav">
				<li class="active"><span class="bar-info">活动介绍</span></li>
				<li><span class="bar-activity">公益活动</span></li>
				<li><span class="bar-leader">领队介绍</span></li>
				<li><span class="bar-about">关于可野</span></li>
				<li><span class="bar-partner">合作伙伴</span></li>
			</ul>
			<div class="bar-footer">
				<span class="bar-footer-title">商务洽谈</span>
				<img src="images/roundchina/code@2x.png" alt="">
				<div class="footer-content">
					<p>
						<span class="name">庆江</span>
						<span class="icon-mobile"></span>
						<span>电话：13810053040</span>
					</p>
					<p>
						<span class="name"></span>
						<span class="icon-wechat"></span>
						<span>微信：qingjiang</span>
					</p>
					<p>
						<span class="name"></span>
						<span class="icon-mobile"></span>
						<span>电话：13920225633</span>
					</p>
					<p>
						<span class="name">马腾</span>
						<span class="icon-wechat"></span>
						<span>微信：ikari33</span>
					</p>
				</div>
			</div>
		</div>
	</div>

	<div class="navigation">
		<span class="icon-top"></span>
		<span class="icon-bottom"></span>
	</div>
@endsection
