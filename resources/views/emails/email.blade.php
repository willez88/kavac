@component('mail::message')
Has recibido un correo de: {{ $fromEmail }}

Asunto: {{ $subjectMsg }}

{!! $messageText !!}

Gracias,<br>
{{ $fromEmail }}
@endcomponent
