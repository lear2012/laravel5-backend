@extends('frontend.layouts.roundchina')

@section('content')
	<div class="enroll has-header">
		<header>
			<span class="" id="menu"></span>
		</header>

		<div class="navbar">
			<span class="icon-back"></span>
			<span class="icon-apply-chetie title">申请车贴</span>
		</div>

		<div class="content">
			<div class="input-item">
				<input type="text" placeholder="姓名" value="" name="name" id="name" />
			</div>
			<div class="input-item">
				<input type="text" placeholder="联系方式" value="" name="mobile" id="mobile" />
			</div>
			<div class="input-item">
				<input type="text" placeholder="车型:如Jeep牧马人" value="" name="brand" id="brand" />
			</div>

			<div class="select-group">
				<div class="input-item" id="addr_start">
					<span class="input-label">起点</span>
					<select>
						<option value="">选择起点</option>
                        @foreach($points as $point)
                            <option value="{{$point}}">{{$point}}</option>
                        @endforeach
					</select>
				</div>
				到
				<div class="input-item" id="addr_end">
					<span class="input-label">终点</span>
					<select>
						<option value="">选择终点</option>
                        @foreach($points as $point)
                            <option value="{{$point}}">{{$point}}</option>
                        @endforeach
					</select>
				</div>
			</div>

			<div class="input-item">
				<input type="text" placeholder="您的住址(我们将向该地址邮寄车贴)" value="" name="address" id="address" />
			</div>

            <div class="textarea-item">
                <textarea name="detail" id="detail" placeholder="申请原因" cols="51" rows="3"></textarea>
            </div>

			<div class="button button-block submit" id="apply_chetie_submit">提交申请</div>

		</div>
	</div>


@endsection
