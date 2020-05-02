@extends('layouts.app')

@section('top-nav-bar')
    @parent
@endsection

@section('content')
    <div class="row">
        <div id="gui" class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h1>{!! __('messages.leaderboard') !!}</h1>
            <ul>
                @if(!count($users))
                    <li>
                        <h5>No leaderboard entries</h5>
                    </li>
                @else
                    @foreach($users as $key => $user)
                        <li>
                            {!! $user->name !!}<br>
                            Gold: {!! $user->gold !!}<br>
                            Attack value: {!! $user->attack_value !!}<br>
                            Hit points: {!! $user->hit_points !!}<br>
                            Luck: {!! $user->luck_value !!}<br>
                            <hr>
                        </li>

                    @endforeach
                @endif
            </ul>
        </div>
    </div>
@endsection

@section('js')
    @parent()
@endsection
