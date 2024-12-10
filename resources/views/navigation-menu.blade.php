<nav class="flex flex-col flex-grow gap-4 justify-between">
    <div class="w-full flex flex-col items-start justify-start space-y-2">
        <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link href="{{ route('appointments') }}" :active="request()->routeIs('appointments')">
            {{ __('Appointments') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link href="{{ route('doctors') }}"
                               :active="request()->routeIs('doctors') ||  request()->is('doctors/*')">
            {{ __('Doctors') }}
        </x-responsive-nav-link>

        <x-responsive-nav-link href="{{ route('users') }}" :active="request()->routeIs('users')">
            {{ __('Users') }}
        </x-responsive-nav-link>
    </div>
    <div class="w-full flex flex-col justify-end pt-4 border-t border-t-gray-300">
        <a href="{{ route('profile.show') }}" class="flex items-center w-full py-2 px-3 mb-4">
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div class="shrink-0 me-3">
                    <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                         alt="{{ Auth::user()->name }}"/>
                </div>
            @endif
            <div class="text-start">
                <div class="font-medium text-base text-neutral-900 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-light text-xs text-neutral-900 dark:text-gray-200">{{ Auth::user()->email }}</div>
            </div>
        </a>
        <form method="POST" action="{{ route('logout') }}" x-data
              class="flex text-center bg-primary-600 hover:bg-primary-500 rounded-lg text-white text-sm">
            @csrf

            <a href="{{ route('logout') }}" class="w-full px-4 py-2"
               @click.prevent="$root.submit();">
                {{ __('Log Out') }}
            </a>
        </form>
    </div>
</nav>
