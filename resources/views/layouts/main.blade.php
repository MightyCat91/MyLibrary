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
                console.log(1);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: $(this).attr('data-href'),
                    data: '1',
                    type: 'POST'
                })
                    .done(function () {

                        console.log('good')
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
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/Library/BootstrapNotify/bootstrap-notify.css') }}">
    @include('alert')
</main>
