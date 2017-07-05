<link href="{{ asset('/css/Custom/alert.css') }}" rel="stylesheet" type='text/css' media="all">
<div id="alert-container" class="alert alert-{{ Session::get('alert.type') ?? $type }} alert-dismissible"
     data-lifetime="{{ Session::get('alert.lifetime') ?? $lifetime }}">
    <i class="fa fa-fw {{ Session::get('alert.icon') ?? $icon }}" aria-hidden="true"></i>
    {{ Session::get('alert.message') ?? $message }}
</div>
<script type="text/javascript" src="{{ asset('/js/Custom/alert.js') }}"></script>