{{--@if (Session::has('alert'))--}}
{{--<link href="{{ asset('/css/Custom/alert.css') }}" rel="stylesheet" type='text/css' media="all">--}}
{{--@foreach(Session::get('alert') as $key => $alert)--}}
{{--@include('alert::alertContent', ['alert' => $alert])--}}
{{--{{ \Debugbar::info('1234') }}--}}
{{--<div id="alert-container">--}}
{{--<div class="alert alert-{{ $alert['type'] ?? $type }} alert-dismissible"--}}
{{--data-lifetime="{{ $alert['lifetime'] ?? $lifetime }}">--}}
{{--<i class="fa fa-fw {{ $alert['icon'] ?? $icon }}" aria-hidden="true"></i>--}}
{{--{{ $alert['message'] ?? $message }}--}}
{{--<i class="fa fa-times" aria-hidden="true"></i>--}}
{{--</div>--}}
{{--</div>--}}
{{--@endforeach--}}
{{--{{ \Session::forget('alert') }}--}}
{{--<script type="text/javascript" src="{{ asset('/js/Custom/alert.js') }}"></script>--}}
{{--@endif--}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.js"></script>
<link rel="stylesheet" type="text/css"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/css/bootstrap-notify.css">

<div class='notifications top-right'></div>

@if(Session::has('success'))
    $('.top-right').notify({
    message: { text: "{{ Session::get('success') }}" }
    }).show();
    @php
        Session::forget('success');
    @endphp
@endif

@if(Session::has('info'))
    $('.top-right').notify({
    message: { text: "{{ Session::get('info') }}" },
    type:'info'
    }).show();
    @php
        Session::forget('info');
    @endphp
@endif

@if(Session::has('warning'))
    $('.top-right').notify({
    message: { text: "{{ Session::get('warning') }}" },
    type:'warning'
    }).show();
    @php
        Session::forget('warning');
    @endphp
@endif

@if(Session::has('error'))
    $('.top-right').notify({
    message: { text: "{{ Session::get('error') }}" },
    type:'danger'
    }).show();
    @php
        Session::forget('error');
    @endphp
@endif
