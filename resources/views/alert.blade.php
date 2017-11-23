<script src="{{ asset('/js/Library/BootstrapNotify/bootstrap-notify.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('/css/Library/BootstrapNotify/bootstrap-notify.css') }}">

<script type="text/javascript" charset="utf-8">
    $(function () {
        @if(Session::has('alert'))
            @switch(Session::get('type'))
                @case('success')
        {{ \Debugbar::info(2) }}
                    $.notify({
                        icon: '<i class="fa fa-check" aria-hidden="true"></i>',
                        message: '{{ Session::get('message') }}'
                    },{
                        type: '{{ Session::get('type') }}'
                    });
                    @php
                    Session::forget('alert')
                    @endphp
                @break
                @case(2)

                @break
            @endswitch
        {{--@if(isset($alert))--}}
        {{--$.notify({--}}
            {{--icon: '<i class="fa fa-check" aria-hidden="true"></i>',--}}
            {{--message: '{{ $alert->message }}'--}}
        {{--},{--}}
            {{--type: 'success'--}}
        {{--});--}}
        {{--@php--}}
            {{--Session::forget('success')--}}
        {{--@endphp--}}
        {{--@endif--}}

        {{--@if(Session::has('info'))--}}
        {{--$.notify({--}}
            {{--icon: '<i class="fa fa-info" aria-hidden="true"></i>',--}}
            {{--message: "{{ Session::get('info') }}"--}}
        {{--},{--}}
            {{--type: 'info'--}}
        {{--});--}}
        {{--@php--}}
            {{--Session::forget('info')--}}
        {{--@endphp--}}
        {{--@endif--}}

        {{--@if(Session::has('warning'))--}}
        {{--$.notify({--}}
            {{--icon: '<i class="fa fa-exclamation-circle" aria-hidden="true"></i>',--}}
            {{--message: "{{ Session::get('warning') }}"--}}
        {{--},{--}}
            {{--type: 'warning'--}}
        {{--});--}}
        {{--@php--}}
            {{--Session::forget('warning')--}}
        {{--@endphp--}}
        {{--@endif--}}

        {{--@if(Session::has('error'))--}}
        {{--$.notify({--}}
            {{--icon: '<i class="fa fa-times" aria-hidden="true"></i>',--}}
            {{--message: "{{ Session::get('error') }}"--}}
        {{--},{--}}
            {{--type: 'error'--}}
        {{--});--}}
        {{--@php--}}
            {{--Session::forget('error')--}}
        {{--@endphp--}}
        {{--@endif--}}
        @endif
    });
</script>