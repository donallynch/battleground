@extends('layouts.app')

@section('top-nav-bar')
    @parent
@endsection

@section('content')
    <div class="row">
        <div id="gui" class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <h5>{!! __('messages.create-player') !!}</h5>
            {!! Form::open(['class' => 'form']) !!}
            <div class="form-group field">
                <small class="form-text text-muted">{!! __('messages.name') !!}</small>
                {{Form::text('name', '', ['class' => 'form-control form-control-sm', 'id' => 'name', 'placeholder' => __('messages.enter-name')])}}
            </div>
            <div class="form-group field">
                <small class="form-text text-muted">{!! __('messages.gold') !!}</small>
                {{Form::text('gold', '', ['class' => 'form-control form-control-sm', 'id' => 'gold', 'placeholder' => __('messages.enter-gold')])}}
            </div>
            <div class="form-group field">
                <small class="form-text text-muted">{!! __('messages.strength') !!}</small>
                {{Form::text('strength', '', ['class' => 'form-control form-control-sm', 'id' => 'strength', 'placeholder' => __('messages.enter-strength')])}}
            </div>
            <div class="form-group field">
                <small class="form-text text-muted">{!! __('messages.health') !!}</small>
                {{Form::text('health', '', ['class' => 'form-control form-control-sm', 'id' => 'health', 'placeholder' => __('messages.enter-health')])}}
            </div>
            <div class="form-group field">
                <small class="form-text text-muted">{!! __('messages.luck') !!}</small>
                {{Form::text('luck', '', ['class' => 'form-control form-control-sm', 'id' => 'luck', 'placeholder' => __('messages.enter-luck')])}}
            </div>
            <div class="feedback mt-2 mb-4"></div>
            <div class="form-group field">
                {{Form::button(__('messages.create-player'), ['class' => 'btn btn-primary btn-sm btn-wide create-player-post'])}}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('js')
    @parent()
    <script src="{{ asset('/js/create-player.js') }}"></script>
@endsection
