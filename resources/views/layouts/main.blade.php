@include("layouts.header")

<!-- Menu Sidebar -->
@include("layouts.menu_sidebar")
<!-- Menu Sidebar -->
<main class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <!-- Content -->
    @yield('content')
    <!-- /Content -->

    <!-- Footer -->
    @include("layouts.footer")
    <!-- Footer --> 
</main>
