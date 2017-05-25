@if (Session::exists('alert'))
    <link href="{{ asset('/css/Custom/alert.css') }}" rel="stylesheet" type='text/css' media="all">
    <div id="alert-container" class="alert alert-{{ Session::get('alert.type') }} alert-dismissible"
         data-lifetime="{{ Session::get('alert.lifetime') }}">
        <i class="fa fa-fw {{ Session::get('alert.icon') }}" aria-hidden="true"></i>
        {{ Session::get('alert.message') }}
    </div>
    <script type="text/javascript" src="{{ asset('/js/Custom/alert.js') }}"></script>
@endif