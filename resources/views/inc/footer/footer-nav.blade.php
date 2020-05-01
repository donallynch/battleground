@section('footer-nav')
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link get-app" href="">{!! __('messages.get-the-app') !!}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link feedback-form" href="">{!! __('messages.feedback') !!}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('help-centre') }}">{!! __('messages.help-centre') !!}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link careers" href="{{ route('careers') }}">{!! __('messages.careers') !!}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link terms" href="">{!! __('messages.terms') !!}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link privacy" href="">{!! __('messages.privacy') !!}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link cookie-policy" href="">{!! __('messages.cookie-policy') !!}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link covid-19-policy" href="">{!! __('messages.covid-19-policy') !!}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('contact-us') }}">{!! __('messages.contact-us') !!}</a>
        </li>
    </ul>
    @show()
