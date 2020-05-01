@extends('layouts.app')

@section('top-nav-bar')
    @parent
@endsection

@section('content')
    <div class="row">
        <div id="gui" class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h1>{!! __('messages.battles') !!}</h1>
            <ul>
                {{-- IF NO BATTLE LOG ENTRIES --}}
                @if(!count($battleLog))
                    <li>
                        <h5>{!! __('messages.No battles pending') !!}</h5>
                    </li>
                @else
                    {{-- FOREACH BATTLE LOG ENTRY --}}
                    @foreach($battleLog as $battle)
                        <li>
                            Round {!! $battle['entryCount'] !!}<br>
                            {!! $battle['player1'] !!} VS {!! $battle['player2'] !!}<br>
                            <strong>{!! $battle['status'] !!}</strong>

                            @if(isset($battle['isPlayerBLucky']))
                                Was {!! $battle['player2'] !!} Lucky: {!! ($battle['isPlayerBLucky']) ? 'Yes' : 'No' !!}<br>
                            @endif
                            @if(isset($battle['attackStrength']))
                                Attack strength: {!! $battle['attackStrength'] !!}<br>
                            @endif
                            @if(isset($battle['opponentNewStrength']))
                                {!! $battle['player2'] !!} new strength: {!! $battle['opponentNewStrength'] !!}
                            @endif
                            @if(isset($battle['healthDeduction']))
                                Health deduction: {!! $battle['healthDeduction'] !!}
                            @endif
                            @if(isset($battle['winnings']))
                                Winnings: {!! $battle['winnings'] !!}
                            @endif
                            <hr>
                        </li>
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
