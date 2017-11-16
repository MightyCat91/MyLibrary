@include("layouts.header",['title'=>$title])
        <!-- Menu Sidebar -->
@include("layouts.menu_sidebar")
        <!-- Menu Sidebar -->

<main class="main">
    <a href="{{ route('test') }}">test</a>
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
    @include('alert')
</main>
