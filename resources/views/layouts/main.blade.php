@include("layouts.header",['title'=>$title])
        <!-- Menu Sidebar -->
@include("layouts.menu_sidebar")
        <!-- Menu Sidebar -->

<main class="main">
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

    <!-- Alert -->
    @include('alert')
    <!-- Alert -->
</main>
