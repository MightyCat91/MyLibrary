<script type="text/javascript" charset="utf-8">
    $(function () {
        @if(Session::has('alert'))
            @foreach(Session::get('alert') as $alert)
                @switch($alert['type'])
                    @case('success')
                        $.notify({
                            icon: 'fa fa-check fa-lg',
                            message: '{{ $alert['message'] }}'
                        },{
                            type: '{{ $alert['type'] }}',
                            delay: '{{ $alert['delay'] }}',
                            spacing: 5
                        });
                    @break
                    @case('info')
                        $.notify({
                            icon: 'fa fa-info-circle fa-lg',
                            message: '{{ $alert['message'] }}'
                        },{
                            type: '{{ $alert['type'] }}',
                            delay: '{{ $alert['delay'] }}',
                            spacing: 5
                        });
                    @break
                    @case('warning')
                        $.notify({
                            icon: 'fa fa-exclamation-circle fa-lg',
                            message: '{{ $alert['message'] }}'
                        },{
                            type: '{{ $alert['type'] }}',
                            delay: '{{ $alert['delay'] }}',
                            spacing: 5
                        });
                    @break
                    @case('danger')
                        $.notify({
                            icon: 'fa fa-lock fa-lg',
                            message: '{{ $alert['message'] }}'
                        },{
                            type: '{{ $alert['type'] }}',
                            delay: '{{ $alert['delay'] }}',
                            spacing: 5
                        });
                    @break
                @endswitch
            @endforeach
            {{ Session::forget('alert') }}
        @endif
    });
</script>