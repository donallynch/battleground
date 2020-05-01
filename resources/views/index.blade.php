@extends('layouts.app')

@section('top-nav-bar')
    @parent
@endsection

@section('content')
    <div class="row">
        <div id="gui" class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="jumbotron">
                <h1 class="display-4">{!! __('messages.battleground') !!}</h1>
                <p class="lead">{!! __('messages.pick-your-battle') !!}</p>
                <hr class="my-4">
                <p>{!! __('messages.fight-to-the-death') !!}</p>
                <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
            </div>
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="{!! route('leaderboard') !!}">{!! __('messages.leaderboard') !!}</a>
                </li>
                <li class="list-group-item">
                    <a href="{!! route('battles') !!}">{!! __('messages.process-battle-queue') !!}</a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('footer-nav')
    @parent
@endsection

@section('js')
    @parent()
@endsection
