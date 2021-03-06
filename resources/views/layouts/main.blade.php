@include("layouts.header",['title'=>$title])
<main class="main">
    <!-- Menu Sidebar -->
    @include("layouts.menu_sidebar")
    <!-- Menu Sidebar -->
    @include("layouts.search")
    <section class="container-content">
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
