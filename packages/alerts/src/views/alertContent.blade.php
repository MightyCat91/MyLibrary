
<div id="alert-container">
    <div class="alert alert-{{ $alert['type'] ?? $type }} alert-dismissible"
         data-lifetime="{{ $alert['lifetime'] ?? $lifetime }}">
        <i class="fa fa-fw {{ $alert['icon'] ?? $icon }}" aria-hidden="true"></i>
        {{ $alert['message'] ?? $message }}
        <i class="fa fa-times" aria-hidden="true"></i>
    </div>
</div>
