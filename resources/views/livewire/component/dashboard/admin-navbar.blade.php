<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class () extends Component {
    public function logout()
    {
        Auth::logout();
        return redirect()->route('homepage');
    }
}; ?>

<header class="bg-background2 shadow-b-md sticky top-0 z-[99]" x-data="{ open: false }">
    <aside class="absolute left-0 top-0 h-screen bg-background2 p-4" x-show="open" x-cloak
        x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="relative">

            <nav class="flex flex-col gap-4 mr-24">
                <x-nav-link :href="route('dashboard.overview')" :active="request()->routeIs('dashboard.overview')" wire:navigate>{{ __('Overview') }}</x-nav-link>
                <x-nav-link :href="route('dashboard.posts')" :active="request()->routeIs('dashboard.posts')" wire:navigate>{{ __('Post') }}</x-nav-link>
                <x-nav-link :href="route('dashboard.profile')" :active="request()->routeIs('dashboard.profile')" wire:navigate>{{ __('Profile') }}</x-nav-link>
            </nav>

            <svg x-show="open" x-cloak @click="open = false" x-transition.opacity xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="absolute top-0 right-0 w-6 h-6 md:hidden hover:text-ancent">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>
    </aside>
    <div class="w-full py-2 px-4 flex justify-between items-center container">
        <div class="flex items-center gap-4 py-2">
            <button type="button" @click="open = !open" class="md:hidden hover:text-ancent relative w-6 h-6">
                <svg x-show="!open" x-transition.opacity xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="absolute inset-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
            <a href="{{ route('dashboard.overview') }}" class="font-mono mr-10">
                <h3>usernob_blog</h3>
            </a>
            <nav>
                <div class="gap-8 items-center hidden md:flex">
                    <x-nav-link :href="route('dashboard.overview')" :active="request()->routeIs('dashboard.overview')" wire:navigate>{{ __('Overview') }}</x-nav-link>
                    <x-nav-link :href="route('dashboard.posts')" :active="request()->routeIs('dashboard.posts')" wire:navigate>{{ __('Post') }}</x-nav-link>
                    <x-nav-link :href="route('dashboard.profile')" :active="request()->routeIs('dashboard.profile')" wire:navigate>{{ __('Profile') }}</x-nav-link>
                </div>
            </nav>
        </div>
        <div class="flex items-center gap-4 py-4">
            <button type="button" @click="$store.darkmode.toggle()" class="hover:text-ancent relative w-6 h-6">
                <svg x-show="!$store.darkmode.on" x-transition.opacity class="absolute w-6 h-6 inset-0"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                </svg>
                <svg x-show="$store.darkmode.on" x-cloak x-transition.opacity class="absolute w-6 h-6 inset-0"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                </svg>
            </button>
            <button type="button" class="hover:text-ancent relative w-6 h-6" wire:click="logout">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 inset-0">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
            </button>
        </div>
    </div>
</header>
