@extends('frontend.layouts.master')
@section('styles')
@endsection
@section('content')
    <section>
        <img class="portrait" src="{{ $user->avatar }}" />
        <p class="name">{{ $user->nickname }}</p>
        <div class="info">
            <div>{{ $user->sex == 1 ? '男' : '女' }}</div>
            <div>可野龄：{{ $user->keye_age }}年</div>
        </div>
        <p class="sign">{{ $user->quotation }}</p>
    </section>
    <hr />
    <footer>
        <div id="nest_info">{{ $user->nest_info }}</div>
    </footer>
@endsection

@section('scripts')

@endsection