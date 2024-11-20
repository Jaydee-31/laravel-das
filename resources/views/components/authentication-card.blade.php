<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-10 py-10 bg-white dark:bg-neutral-900 dark:ring-white/10 shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
