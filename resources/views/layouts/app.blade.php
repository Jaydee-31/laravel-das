<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>

    <meta name="application-name" content="{{ config('app.name') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600&display=swap" rel="stylesheet"/>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <style>
        /* Custom overlay for dark tint */
        .overlay {
            background-color: rgba(0, 0, 0, 0.5);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9;
        }
    </style>

    @filamentStyles
    @vite('resources/css/app.css')
</head>
<body class="h-screen bg-gray-100 overflow-y-hidden">

<div x-data="{ isSidebarOpen: false }" class="flex h-full w-full">
    <!-- Sidebar -->
    <aside :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed top-0 left-0 h-full w-64 bg-white text-black transform transition-transform duration-300 lg:relative lg:translate-x-0 z-20 p-4 flex flex-col border-e">
        <div class="bg-white h-20 w-full flex items-center justify-center mb-4">
            <!-- Logo -->
            <a href="{{ route('dashboard') }}">
                <x-application-mark class="h-9 w-auto"/>
            </a>
        </div>

        @livewire('navigation-menu')
    </aside>

    <!-- Overlay (only shown on small screens when sidebar is open) -->
    <div x-show="isSidebarOpen" x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:leave="transition-opacity ease-in duration-200" class="overlay lg:hidden"
         @click="isSidebarOpen = false"></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col w-full ">
        <header class="flex h-16 w-full gap-4 justify-between md:px-4 px-2 border-b">
            <div class="flex h-full items-center">
                <button @click="isSidebarOpen = !isSidebarOpen" class="p-2 focus:outline-none lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 6h16.5M3.75 12h16.5M3.75 18h16.5"/>
                    </svg>
                </button>
            </div>
            <h1 class="flex-grow self-center hidden md:block">Doctors Appointment System Bethel Baptist
                Hospital Inc.</h1>

            <a class="flex gap-3 lg:me-4 me-2 cursor-pointer" href="{{ route('dashboard') }}">
                <div class="flex h-full justify-center items-end flex-col">
                    <p class="font-light text-xs">Today's date</p>
                    <h4 class="font-medium text-lg tracking-wider">{{Carbon\Carbon::now()->toDateString("Y-m-d")}}</h4>
                </div>
                <div class="flex h-full justify-center items-center">
                    <div class="p-2 bg-primary-100 border rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                        </svg>
                    </div>
                </div>
            </a>
        </header>

        <main class="flex-1 mt-16 overflow-y-auto">
            {{ $slot }}
            @livewire('notifications')
        </main>
    </div>
</div>


@livewireCalendarScripts
@filamentScripts
@vite('resources/js/app.js')

</body>
</html>
