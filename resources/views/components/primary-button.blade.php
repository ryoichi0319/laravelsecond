@props(['disabled', 'color' => 'green'])

@php
    $isDisabled = isset($disabled) ? $disabled : false;
@endphp

@php
    $colors = [
        'green' => 'bg-green-800 hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:ring-indigo-500',
        'blue' => 'bg-blue-800 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:ring-indigo-500',
        // ここに追加の色を追加する
    ];
@endphp

@php
    $buttonClasses = 'inline-flex items-center px-4 py-4 border border-transparent
                      rounded-md font-semibold text-xl text-white uppercase tracking-widest 
                      focus:outline-none focus:ring-2 focus:ring-offset-2 transition 
                      ease-in-out duration-150 disabled:opacity-25 shadow-lg'; // 影を追加
@endphp

<button {{ $attributes->merge(['type' => 'submit', 
       'class' => $buttonClasses . ' ' . $colors[$color] ?? $colors['green']]) }}
       {{ $isDisabled ? 'disabled' : '' }}>
    {{ $slot }}
</button>


