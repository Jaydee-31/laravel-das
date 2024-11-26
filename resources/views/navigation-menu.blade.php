<nav class="h-full pt-4 bg-white dark:bg-neutral-900 dark:border-neutral-800">
    <div class="flex flex-col h-dvh">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('appointments') }}" :active="request()->routeIs('appointments')">
                {{ __('Appointments') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('doctors') }}" :active="request()->routeIs('doctors')">
                {{ __('Doctors') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('users') }}" :active="request()->routeIs('users')">
                {{ __('Users') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="absolute p-4 inset-x-0 bottom-0 border-t border-gray-200 dark:border-gray-600">
            <div class="flex items-center px-4">
                <a href="{{ route('profile.show') }}" class="flex items-center">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div class="shrink-0 me-3">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        </div>
                    @endif

                    <div>
                        <div class="font-medium text-base text-neutral-900 dark:text-gray-200">{{ Auth::user()->name }}</div>
                        <div class="font-light text-xs text-neutral-900 dark:text-gray-200">{{ Auth::user()->email }}</div>
                    </div>
                </a>

            </div>

            <div class="mt-4 space-y-1">
                <!-- Account Management -->

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data class="w-full text-center bg-primary-600 hover:bg-primary-500 px-4 py-2 rounded text-white text-sm ">
                    @csrf

                    <a href="{{ route('logout') }}" class=""
                                   @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </a>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200 dark:border-gray-600"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-responsive-nav-link>
                    @endcan

                    <!-- Team Switcher -->
                    @if (Auth::user()->allTeams()->count() > 1)
                        <div class="border-t border-gray-200 dark:border-gray-600"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-switchable-team :team="$team" component="responsive-nav-link" />
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</nav>
