@include("layouts.header")

<!-- Menu Sidebar -->
@include("layouts.menu_sidebar")
<!-- Menu Sidebar -->
<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 main">
    <!-- Content -->
    <div class="page-content">
        @yield('content')
    </div>
    <!-- /Content -->

    <!-- Footer -->
    @include("layouts.footer")
    <!-- Footer --> 
</main>
