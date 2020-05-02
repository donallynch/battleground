@extends('layouts.app')

@section('top-nav-bar')
    @parent
@endsection

@section('content')
    <div class="row">
        <div id="gui" class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <h5>{!! __('messages.login') !!}</h5>
            <p>
                {!! __('messages.login-notice') !!}
            </p>
            {!! Form::open(['class' => 'form']) !!}
                <div class="form-group field">
                    <small class="form-text text-muted">{!! __('messages.name') !!}</small>
                    {{Form::text('name', '', ['class' => 'form-control form-control-sm', 'id' => 'name', 'placeholder' => __('messages.enter-your-name')])}}
                </div>
                <div class="feedback mt-2 mb-4"></div>
                <div class="form-group field">
                    {{Form::button(__('messages.login'), ['class' => 'btn btn-primary btn-sm btn-wide login-post'])}}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('js')
    @parent()
    <script src="{{ asset('/js/login.js') }}"></script>
@endsection
