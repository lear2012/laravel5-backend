@extends('frontend.layouts.master')
@section('styles')
@endsection
@section('content')
<div class="information">
    <section>
        <img class="portrait" src="{{ $user->profile->avatar }}" />
        <p class="name">{{ $user->username }}</p>
        <div class="info">
            <div>{{ $user->sex == 1 ? '男' : '女' }}</div>
            <div>可野龄：{{ $user->profile->keye_age }}年</div>
        </div>
        <p class="sign">{{ $user->profile->quotation }}</p>
    </section>
    <hr />
    <footer>
        <div id="nest_info"><img src="https://www.baidu.com/img/bd_logo1.png" /></div>
    </footer>
</div>
@endsection

@section('scripts')

@endsection