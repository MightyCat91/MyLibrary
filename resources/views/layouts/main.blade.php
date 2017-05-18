@include("layouts.header")

<!-- Menu Sidebar -->
@include("layouts.menu_sidebar")
<!-- Menu Sidebar -->
<main class="main">
    <section class="container-content row">
        <!-- Content -->
        <div class="page-content">
            @yield('content')
            <button class="btn btn-default" onsubmit="{{ route('alert') }}"></button>
        </div>
        <!-- /Content -->
        @yield('alphabetFilter')
    </section>
    <!-- Footer -->
    @include("layouts.footer")
    <!-- Footer --> 
</main>
