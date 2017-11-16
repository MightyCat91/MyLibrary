<script src="{{ asset('/js/Library/BootstrapNotify/bootstrap-notify.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('/css/Library/BootstrapNotify/bootstrap-notify.css') }}">



<div class='notifications top-right'></div>

<script type="text/javascript" charset="utf-8">
    $(function () {
        @if (Session::has('test'))
        $('body').notify({
            message: 'Hello World',
            type: 'danger'
        });
        @endif

                @if(Session::has('success'))
                $('.notifications').notify({
                    message: {text: "{{ Session::get('success') }}"}
                }).show();
                @php
                    Session::forget('success');
                @endphp
                @endif

                @if(Session::has('info'))
                $('.top-right').notify({
                    message: {text: "{{ Session::get('info') }}"},
                    type: 'info'
                }).show();
                @php
                    Session::forget('info');
                @endphp
                @endif

                @if(Session::has('warning'))
                $('.top-right').notify({
                    message: {text: "{{ Session::get('warning') }}"},
                    type: 'warning'
                }).show();
                @php
                    Session::forget('warning');
                @endphp
                @endif

                @if(Session::has('error'))
                $('.top-right').notify({
                    message: {text: "{{ Session::get('error') }}"},
                    type: 'danger'
                }).show();
                @php
                    Session::forget('error');
                @endphp
                @endif
        });
</script>