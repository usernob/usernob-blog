@props(['active' => false])

@php
$classes = $active ?
            'transition-all duration-200 ease-in-out hover:text-ancent font-bold text-ancent' :
            'transition-all duration-200 ease-in-out hover:text-ancent font-semibold';

@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
