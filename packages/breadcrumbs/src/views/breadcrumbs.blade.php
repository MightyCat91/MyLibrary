@unless(empty($breadcrumbs))
    <link href="{{ asset('/css/Custom/breadcrumbs.css') }}" rel='stylesheet' type='text/css' media="all"/>
    <div id="breadcrumbs" class="container">
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb && $loop->remaining)
                <a class="breadcrumbs-item" href="{{ $breadcrumb['url'] }}">
                    @if($breadcrumb['url'] == route('home'))
                        <i class="fa fa-home fa-lg fa-fw" aria-hidden="true"></i>
                    @else
                        {{ $breadcrumb['title'] }}
                    @endif
                </a>
                /
            @else
                <span class="active">{{ $breadcrumb['title'] }}</span>
            @endif
        @endforeach
    </div>
@endunless