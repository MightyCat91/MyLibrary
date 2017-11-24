@include("layouts.header",['title'=>$title])
        <!-- Menu Sidebar -->
@include("layouts.menu_sidebar")
        <!-- Menu Sidebar -->

<main class="main">
    <div data-href="{{ url('test') }}" id="test">test</div>
    <script type="text/javascript" src="{{ asset('/js/Library/jQuery/jquery-3.2.1.min.js') }}"></script>
    <script>
        (function($){
            $('#test').click(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: $(this).attr('data-href'),
                    type: 'POST'
                })
                    .done(function () {
                        $.getScript( "/js/Custom/Alert.js", function () {
                            Alert('success', 'test message', 0);
                        });
                        {{--console.log({{ asset('/js/Custom/Alert.js') }})--}}
                    });
            })
        })(jQuery);
    </script>
    <section class="container-content row">
        <!-- Content -->
        <div class="page-content">
            @yield('content')
        </div>
        <!-- /Content -->
        @yield('alphabetFilter')
    </section>

    <!-- Footer -->
    @include("layouts.footer")
            <!-- Footer -->
    <script src="{{ asset('/js/Library/BootstrapNotify/bootstrap-notify.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/Custom/alert.css') }}">
    @include('alert')
</main>
