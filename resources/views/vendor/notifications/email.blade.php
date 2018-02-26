@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# Whoops !
@else
# Bonjour !
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
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach



![Some option text]({{ asset('img/merci.jpg') }})


{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Cordialement,<br>Toute l'équipe de la Com' 
@endif

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
{{-- Si vous avez des problèmes avec le bouton "{{ $actionText }}", copiez et collez l'adresse suivante dans votre navigateur : [{{ $actionUrl }}]({{ $actionUrl }})
<br>
 --}}
Ceci est un mail automatique, merci de ne pas y répondre.
@endcomponent
@endisset
@endcomponent
