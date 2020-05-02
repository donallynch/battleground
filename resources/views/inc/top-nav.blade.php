@section('top-nav-bar')
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="{{ url('/') }}">{!! __('messages.project') !!}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header-nav" aria-controls="header-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">

            {{-- If there's a User in the session --}}
            @if(!empty(session()->get('user')))
                <div class="navbar-nav mr-auto">
                    <button class="btn btn-secondary" type="button" aria-haspopup="false" aria-expanded="false">
                        <span id="header-name-span">{{ session()->get('user')['name'] }}</span>
                    </button>
                </div>
            @endif

        </div>
    </nav>
    @show()
