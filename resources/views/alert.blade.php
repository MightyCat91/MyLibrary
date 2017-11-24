<script src="{{ asset('/js/Library/BootstrapNotify/bootstrap-notify.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('/css/Library/BootstrapNotify/bootstrap-notify.css') }}">

<script type="text/javascript" charset="utf-8">
    $(function () {
        @if(Session::has('alert'))
            @switch(Session::get('type'))
                @case('success')
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
                @case('info')
                    $.notify({
                        icon: '<i class="fa fa-info" aria-hidden="true"></i>',
                        message: '{{ Session::get('message') }}'
                    },{
                        type: '{{ Session::get('type') }}'
                    });
                    @php
                        Session::forget('alert')
                    @endphp
                @break
                @case('warning')
                    $.notify({
                        icon: '<i class="fa fa-exclamation-circle" aria-hidden="true"></i>',
                        message: '{{ Session::get('message') }}'
                    },{
                        type: '{{ Session::get('type') }}'
                    });
                    @php
                        Session::forget('alert')
                    @endphp
                @break
                @case('error')
                    $.notify({
                        icon: '<i class="fa fa-times" aria-hidden="true"></i>',
                        message: '{{ Session::get('message') }}'
                    },{
                        type: '{{ Session::get('type') }}'
                    });
                    @php
                        Session::forget('alert')
                    @endphp
                @break
            @endswitch
        @endif
    });
</script>