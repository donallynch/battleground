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
                        <h5>{!! __('messages.no-battles-pending') !!}</h5>
                    </li>
                @else
                    {{-- FOREACH BATTLE LOG ENTRY --}}
                    @foreach($battleLog as $battle)
                        <li>
                            {!! $battle['player1'] !!} VS {!! $battle['player2'] !!}: Round {!! $battle['entryCount'] !!}<br>
                            <strong>{!! $battle['status'] !!}</strong><br>

                            {{-- DID THE BATTLE TAKE PLACE --}}
                            @if(isset($battle['code']))
                                @if($battle['code'] === 1)
                                    {!! $battle['player1'] !!} swings their axe at {!! $battle['player2'] !!}<br>

                                    {{-- IS PLAYER B LUCKY --}}
                                    @if(isset($battle['isPlayerBLucky']))
                                        {{-- IF PLAYER B DODGED THE ATTACK --}}
                                        @if($battle['isPlayerBLucky'])
                                            <span class="lucky">{!! $battle['player2'] !!} dodged the attack!</span>
                                        @else
                                            <span class="unlucky">{!! $battle['player2'] !!} took a shattering blow!</span>
                                        @endif
                                        <br>
                                    @endif
                                    @if(isset($battle['attackStrength']))
                                        @if($battle['attackStrength'])
                                            <span class="attack"><i class="fas fa-fist-raised" title="{!! __('messages.attack-strength') !!}"></i> -{!! $battle['attackStrength'] !!}</span><br>
                                        @endif
                                    @endif
                                    @if(isset($battle['healthDeduction']))
                                        <i class="fas fa-medkit" title="{!! __('messages.health') !!}"></i>
                                        @if(!$battle['attackStrength'])
                                            {!! $battle['opponentInitialHealth'] !!}
                                        @else
                                            {!! $battle['opponentInitialHealth'] !!} <i class="fas fa-arrow-right small-arrow"></i> {!! $battle['opponentInitialHealth'] - $battle['healthDeduction'] !!}
                                        @endif
                                    @endif
                                    @if(isset($battle['opponentNewStrength']) && isset($battle['opponentNewStrength']))
                                        &middot;
                                        <i class="fas fa-dumbbell" title="{!! __('messages.strength') !!}"></i>
                                        @if(!$battle['attackStrength'] || $battle['opponentInitialStrength'] == $battle['opponentNewStrength'])
                                            {!! $battle['opponentNewStrength'] !!}
                                        @else
                                            {!! $battle['opponentInitialStrength'] !!} <i class="fas fa-arrow-right small-arrow"></i> {!! $battle['opponentNewStrength'] !!}
                                        @endif
                                    @endif

                                    @if(isset($battle['winnings']))
                                        &middot; <i class="fas fa-coins" title="{!! __('messages.gold') !!}"></i>
                                        @if(!$battle['attackStrength'])
                                            {!! $battle['initialGold'] !!}
                                        @else
                                            {!! $battle['initialGold'] !!} <i class="fas fa-arrow-right small-arrow"></i> {!! $battle['initialGold'] - $battle['winnings'] !!}
                                        @endif
                                    @endif
                                @else

                                @endif
                            @endif
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
