<!-- Header -->
@include("layout.header")
<!-- Header -->

<!-- Main -->
<div id="main">
    <div class="container">
        @if (trim($__env->yieldContent('overview')))
            @yield('overview')
        @endif

        <div class="row">
            <!-- Content -->
            @yield('content')
            <!-- /Content -->
            <!-- Sidebar -->
            @yield('sidebar')
            <!-- Sidebar -->
        </div>
    </div>
</div>
<!-- Main -->

<!-- Footer -->
@include("layout.footer")
<!-- Footer -->
