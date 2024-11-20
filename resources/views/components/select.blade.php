{{-- @props(on) --}}

<select {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-neutral-800 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm']) }}>
    {{ $slot }}
</select>