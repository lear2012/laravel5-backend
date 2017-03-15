@extends('frontend.layouts.master')
@section('styles')
@endsection
@section('content')
    <section>
        <img class="portrait" src="{{ $user->profile->avatar }}" />
        <p class="name">{{ $user->profile->nickname }}</p>
        <div class="info">
            <div>{{ $user->sex == 1 ? '男' : '女' }}</div>
            <div>可野龄：{{ $user->profile->keye_age }}年</div>
        </div>
        <p class="sign">{{ $user->profile->quotation }}</p>
    </section>
    <hr />
    <footer>
        <div id="nest_info">{{ $user->profile->nest_info }}</div>
    </footer>
@endsection

@section('scripts')

@endsection