@extends('layouts.app')

@section('top-nav-bar')
    @parent
@endsection

@section('content')
    <div class="row">
        <div id="gui" class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h1>{!! __('messages.battles') !!}</h1>
            <ul>
                @if(!count($battleLog))
                    <li>
                        <h5>No battles pending</h5>
                    </li>
                @else
                    @foreach($battleLog as $key =>$battle)
                        {!! $battle[$key]['player1'] !!} VS {!! $battle[$key]['player2'] !!}<br>
                        Was {!! $battle[$key]['player2'] !!} Lucky: {!! ($battle[$key]['isPlayerBLucky']) ? 'Yes' : 'No' !!}
                        <br>
                        Attack value: {!! $battle[$key]['attackValue'] !!}
                        <br>
                        Winnings: {!! $battle[$key]['winnings'] !!}
                    @endforeach
                @endif
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
