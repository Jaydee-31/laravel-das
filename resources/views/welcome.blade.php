<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600&display=swap" rel="stylesheet"/>

    @filamentStyles
    @vite('resources/css/app.css')
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
<div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
    <section class="pt-12 bg-gray-50 sm:pt-16">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <p
                    class="max-w-4xl mx-auto mb-4 text-center text-4xl font-black leading-tight text-gray-900 sm:leading-tight sm:text-5xl lg:text-6xl lg:leading-tight">
                    Doctors Appointment System
                </p>
                <h1 class="max-w-2xl mx-auto px-6 text-center text-xl text-gray-600 font-inter">
                    Bethel Baptiste Hospital Inc.
                </h1>
                <div class="self-center mt-9">
                    @livewire('scheduler')
                </div>
            </div>
        </div>
        <div class="bg-white">
            <div class="relative mx-auto mt-4 md:mt-8">
                <div class="lg:max-w-4xl lg:mx-auto">
                    <img src="{{url('/images/hero.jpg')}}" class="" alt="hero-image"/>
                </div>
            </div>
        </div>
    </section>
</div>
@livewire('notifications')
@filamentScripts
@vite('resources/js/app.js')

</body>
</html>
