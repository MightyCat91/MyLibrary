@unless(empty($breadcrumbs))
    <link href="{{ asset('/css/Custom/breadcrumbs.css') }}" rel='stylesheet' type='text/css' media="all"/>
    <div id="breadcrumbs">
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url() && $loop->remaining)
                <a class="breadcrumbs-item" href="{{ $breadcrumb->url() }}">
                    @if($breadcrumb->title()=="Home")
                        <i class="fa fa-home fa-lg fa-fw" aria-hidden="true"></i>
                    @else
                        {{ $breadcrumb->title() }}
                    @endif
                </a>
                <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
            @else
                <span class="active">{{ $breadcrumb->title() }}</span>
            @endif
        @endforeach
    </div>
@endunless