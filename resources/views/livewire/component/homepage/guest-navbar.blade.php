<?php

use App\Models\Tag;
use Livewire\Volt\Component;

new class () extends Component {
    public function with()
    {
        return [
            'tags' => Tag::all(),
        ];
    }
}; ?>

<header class="w-full shadow-md sticky top-0 bg-background2 z-50">
    <div class="container" x-data="{ open: false }">
        <div class="flex justify-between items-center py-4">
            <a id="logo" href="#" class="font-mono font-bold text-md lg:text-xl text-ancent">cd <span
                    class="inline-flex after:min-h-[70%] after:w-[0.6rem] after:sm:w-3 after:animate-blink after:bg-ancent text-foreground">~/
                    <span id="tag">usernob-blog</span> </span>
            </a>
            <div class="flex items-center gap-4">
                <nav class="hidden md:flex items-center gap-10">

                    <x-nav-link :href="route('homepage')" :active="request()->routeIs('homepage')">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('tag')" :active="request()->routeIs('tag')">
                        {{ __('Categories') }}
                    </x-nav-link>
                    <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                        {{ __('About') }}
                    </x-nav-link>

                </nav>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:text-ancent">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </a>
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
                    <button type="button" @click="open = !open" class="md:hidden hover:text-ancent relative w-6 h-6">
                        <svg x-show="!open" x-transition.opacity xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="absolute inset-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <svg x-show="open" x-cloak x-transition.opacity xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="absolute inset-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <nav x-show="open" x-cloak x-collapse class="flex flex-col gap-2 pb-4 md:hidden">

            <x-nav-link :href="route('homepage')" :active="request()->routeIs('homepage')">
                {{ __('Home') }}
            </x-nav-link>
            <x-nav-link :href="route('tag')" :active="request()->routeIs('tag')">
                {{ __('Categories') }}
            </x-nav-link>
            <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                {{ __('About') }}
            </x-nav-link>

        </nav>
    </div>
    <template id="tags">
        <a href="{{ route('homepage') }}">usernob_blog</a>
        @foreach ($tags as $tag)
            <a href="{{ route('tag.post', $tag->name) }}">{{ $tag->name }}</a>
        @endforeach
    </template>

    @vite('resources/js/lib/navbar.js')
</header>
