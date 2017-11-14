@if (Session::has('alert'))
    <link href="{{ asset('/css/Custom/alert.css') }}" rel="stylesheet" type='text/css' media="all">
    @foreach(Session::get('alert') as $key => $alert)
        {{--@include('alert::alertContent', ['alert' => $alert])--}}
        <div id="alert-container">
            <div class="alert alert-{{ $alert['type'] ?? $type }} alert-dismissible"
                 data-lifetime="{{ $alert['lifetime'] ?? $lifetime }}">
                <i class="fa fa-fw {{ $alert['icon'] ?? $icon }}" aria-hidden="true"></i>
                {{ $alert['message'] ?? $message }}
                <i class="fa fa-times" aria-hidden="true"></i>
            </div>
        </div>
        {{\Debugbar::info(time()+$alert['lifetime'])}}
        {{ time_nanosleep($alert['lifetime']) }}
        {{\Debugbar::info(time())}}
        {{ \Session::forget('alert.' . $key) }}
    @endforeach
    <script type="text/javascript" src="{{ asset('/js/Custom/alert.js') }}"></script>
@endif
