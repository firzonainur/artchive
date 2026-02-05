@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full py-3 px-4 bg-gray-800 border border-gray-600 text-white rounded-lg shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500/50 transition-all duration-200 placeholder-gray-500']) !!}>
