@include("layouts.header",['title'=>$title])
        <!-- Menu Sidebar -->
@extends("layouts.menu_sidebar")
        <!-- Menu Sidebar -->
@section('main')
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
        @include('alert::alert')
    </main>
@endsection
