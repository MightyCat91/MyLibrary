<script type="text/javascript" charset="utf-8">
    jQuery(function () {
        @if(Session::has('alert'))
            @foreach(Session::get('alert') as $alert)
                @switch($alert['type'])
                    @case('success')
                        @php $icon = 'fa fa-check fa-lg' @endphp
                        @break
                    @case('info')
                        @php $icon = 'fa fa-info-circle fa-lg' @endphp
                        @break
                    @case('warning')
                        @php $icon = 'fa fa-exclamation-circle fa-lg' @endphp
                        @break
                    @case('danger')
                        @php $icon = 'fa fa-lock fa-lg' @endphp
                        @break
                @endswitch
                $.notify({
                    icon: '{{ $icon }}',
                    message: '{{ $alert['message'] }}'
                },{
                    type: '{{ $alert['type'] }}',
                    delay: '{{ $alert['delay'] }}',
                    spacing: 5,
                    template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                    '<span data-notify="icon"></span> ' +
                    '<div class="alert-wrapper">' +
                    '<span data-notify="title">{1}</span> ' +
                    '<span data-notify="message">{2}</span>' +
                    '<div class="progress" data-notify="progressbar">' +
                    '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                    '</div>' +
                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
                    '</div>' +
                    '<div class="close-wrapper"><button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button></div>' +
                    '</div>'
                });
            @endforeach
            {{ Session::forget('alert') }}
        @endif
    });
</script>