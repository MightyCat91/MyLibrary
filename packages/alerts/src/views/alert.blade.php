@if (Session::has('alert'))
    @foreach(Session::get('alert') as $key => $alert)
        @include('alert::alertContent', ['alert' => $alert])
        {{ \Session::forget($key) }}
    @endforeach
@endif
