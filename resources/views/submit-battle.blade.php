@extends('layouts.app')

@section('top-nav-bar')
    @parent
@endsection

@section('content')
    <div class="row">
        <div id="gui" class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <h5>{!! __('messages.submit-battle') !!}</h5>
            {!! Form::open(['class' => 'form']) !!}
            <div class="form-group field">
                <small class="form-text text-muted">{!! __('messages.player-1') !!}</small>
                {!! Form::select('player-1', $players, 0, ['class' => 'form-control form-control-sm', 'id' => 'player-1', 'placeholder' => __('messages.select-player-1')]) !!}
            </div>
            <div class="form-group field">
                <small class="form-text text-muted">{!! __('messages.player-2') !!}</small>
                {!! Form::select('player-2', $players, 0, ['class' => 'form-control form-control-sm', 'id' => 'player-2', 'placeholder' => __('messages.select-player-2')]) !!}
            </div>
            <div class="feedback mt-2 mb-4"></div>
            <div class="form-group field">
                {{Form::button(__('messages.submit-battle'), ['class' => 'btn btn-primary btn-sm btn-wide submit-battle-post'])}}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('js')
    @parent()
    <script src="{{ asset('/js/submit-battle.js') }}"></script>
@endsection
