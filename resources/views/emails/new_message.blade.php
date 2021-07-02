@component('mail::message')
*PESAN BARU*

**Nama** :  {{-- line break --}}
{{ $name }}  {{-- line break --}}

**Email** :  {{-- line break --}}
{{ $email }}  {{-- line break --}}

**Message** :  {{-- line break --}}
{{ $message }}  {{-- line break --}}

@endcomponent