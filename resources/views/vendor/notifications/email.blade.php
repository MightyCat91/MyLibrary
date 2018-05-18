@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# Whoops!
@else
# Hello!
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach
{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
            $color = 'green';
            break;
        case 'error':
            $color = 'red';
            break;
        default:
            $color = 'blue';
    }
?>
@component('mail::button', ['url' => $actionUrl])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

<!-- Salutation -->
@if (! empty($salutation))
{{ $salutation }}
@else
С уважением,<br>{{ config('mail.from.name') }}
@endif

<!-- Subcopy -->
@isset($actionText)
@component('mail::subcopy')
Если у Вас есть проблемы с нажатием кнопки "{{ $actionText }}", скопируйте ссылку ниже и вставьте ее в адресную строку
Вашего браузера: <a href="{{ $actionUrl }}">Нажмите на эту ссылку</a>
@endcomponent
@endisset
@endcomponent
