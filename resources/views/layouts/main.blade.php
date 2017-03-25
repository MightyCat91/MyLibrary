@include("layouts.header")

<!-- Menu Sidebar -->
@include("layouts.menu_sidebar")
<!-- Menu Sidebar -->
<main class="main">
    <!-- Content -->
    <div class="page-content">
        @yield('content')
    </div>
    <!-- /Content -->

    <!-- Footer -->
    @include("layouts.footer")
    <!-- Footer --> 
</main>
