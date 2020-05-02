@extends('layouts.app')

@section('top-nav-bar')
    @parent
@endsection

@section('content')
    <div class="row">
        <div id="gui" class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="jumbotron index-jumbo">
                <h1 class="display-4 logo-name">{!! __('messages.battleground') !!}</h1>
                <p class="lead">{!! __('messages.pick-your-battle') !!}</p>
                <hr class="my-4">
                <p>{!! __('messages.fight-to-the-death') !!}</p>
                <a class="btn btn-primary btn-lg learn-more" href="#" role="button">
                    {!! __('messages.learn-more') !!}
                </a>
            </div>
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="{!! route('login') !!}">{!! __('messages.login') !!}</a>
                </li>
                <li class="list-group-item">
                    <a href="{!! route('leaderboard') !!}">{!! __('messages.leaderboard') !!}</a>
                </li>
                <li class="list-group-item">
                    <a href="{!! route('battles') !!}">{!! __('messages.process-battle-queue') !!}</a>
                </li>
                <li class="list-group-item">
                    <a href="{!! route('create-player') !!}">{!! __('messages.create-player') !!}</a>
                </li>
                <li class="list-group-item">
                    <a href="{!! route('submit-battle') !!}">{!! __('messages.submit-battle') !!}</a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('js')
    @parent()
    <script src="{{ asset('/js/index.js') }}"></script>
@endsection
