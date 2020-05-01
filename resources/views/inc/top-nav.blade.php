@section('top-nav-bar')
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="{{ url('/') }}">{!! __('messages.project') !!}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header-nav" aria-controls="header-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="header-nav">
            <ul class="navbar-nav mr-auto">

                {{-- If there is a Session Owner; Print User dropdown in header --}}
                @if(isset($sessionOwner) && count($sessionOwner))
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img
                                @if(isset($sessionOwner) && count($sessionOwner->profilePhoto) > 0)
                                    src="{{ asset('images/photo-albums' . $sessionOwner->profilePhoto[1]) }}"
                                @else
                                    src="{{ asset('images/default.jpeg') }}"
                                @endif
                                alt="{!! __('messages.profile-photo') !!}"
                                id="header-profile-pic"
                                class="rounded-circle"
                                width="24"
                                height="24"
                            >
                            <span id="header-name-span">{{ $sessionOwner[0]->first_name }}</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('account', ['username' => $sessionOwner[0]->username]) }}">{!! __('messages.account') !!}</a>
                            <a class="dropdown-item" href="{{ route('logout') }}">{!! __('messages.logout') !!}</a>
                        </div>
                    </div>
                @else

                @endif

            </ul>
        </div>
    </nav>
    @show()
