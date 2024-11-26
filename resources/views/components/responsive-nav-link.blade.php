@props(['active'])

@php
    $classes = ($active ?? false)
    ? 'block w-full ps-3 pe-4 py-2 rounded-lg text-start text-base font-medium text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900/50 focus:outline-none focus:text-blue-800 dark:focus:text-blue-200 focus:bg-blue-100 dark:focus:bg-blue-900 transition duration-150 ease-in-out'
    : 'block w-full ps-3 pe-4 py-2 rounded-lg text-start text-base font-medium text-gray-600 dark:text-gray-400 hover:text-neutral-900 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:text-neutral-900 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
