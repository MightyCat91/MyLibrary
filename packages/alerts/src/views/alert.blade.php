@if (Session::exists('alert'))
    @include('alert::alertContent')
@endif
