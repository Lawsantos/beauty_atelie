@php
    $color = $attributes->get('color') ?? 'gray';
    $buttonClasses = "inline-flex items-center px-4 py-2 bg-{$color}-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-{$color}-700 active:bg-{$color}-900 focus😮utline-none focus:border-{$color}-900 focus:ring ring-{$color}-300 disabled😮pacity-25 transition ease-in-out duration-150";
@endphp
<a {{ $attributes->merge(['class' => $buttonClasses]) }}>
    {{ $slot }}
</a>
