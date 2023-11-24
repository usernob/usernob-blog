<?php

use App\Models\Post;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class () extends Component {
    use WithPagination;

    public function placeholder()
    {
        return <<<'HTML'
            <div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 auto-cols-fr auto-rows-max w-full mb-8">
                    <div class="animate-pulse">
                        <div class="rounded-xl bg-placeholder h-56"></div>
                        <div class="rounded-xl bg-placeholder h-10 mt-4"></div>
                        <div class="rounded-xl bg-placeholder h-16 mt-2 mb-4"></div>
                        <div class="rounded-xl bg-placeholder h-32"></div>
                    </div>
                    <div class="animate-pulse">
                        <div class="rounded-xl bg-placeholder h-56"></div>
                        <div class="rounded-xl bg-placeholder h-10 mt-4"></div>
                        <div class="rounded-xl bg-placeholder h-16 mt-2 mb-4"></div>
                        <div class="rounded-xl bg-placeholder h-32"></div>
                    </div>
                    <div class="animate-pulse">
                        <div class="rounded-xl bg-placeholder h-56"></div>
                        <div class="rounded-xl bg-placeholder h-10 mt-4"></div>
                        <div class="rounded-xl bg-placeholder h-16 mt-2 mb-4"></div>
                        <div class="rounded-xl bg-placeholder h-32"></div>
                    </div>
                </div>
            </div>
        HTML;
    }

    public function with(): array
    {
        return [
            'posts' => Post::latest()->simplePaginate(6),
        ];
    }
}; ?>

<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 auto-cols-fr auto-rows-max w-full mb-8">
        @foreach ($posts as $post)
            <article class="group" wire:key="{{ $post->id }}">
                <div class="aspect-video w-full rounded-xl object-cover shadow-xl overflow-hidden">

                    <img alt="{{ $post->title }}" src="{{ asset($post->thumbnail) }}"
                        class="object-cover w-full h-full transition duration-300 ease-in-out group-hover:scale-105"
                        loading="lazy" />
                </div>
                <div class="mt-4">
                    <time datetime="{{ $post->created_at }}" class="block text-xm text-foreground2">
                        {{ date('M d, Y', strtotime($post->created_at)) }}
                    </time>
                    <a href="{{ route('post.show', ['by' => 'id', 'param' => $post->id]) }}" class="block">
                        <h4
                            class="text-foreground group-hover:text-ancent transition duration-300 ease-in-out mb-3 font-bold">
                            {{ $post->title }}
                        </h4>
                    </a>
                    <div class="flex flex-wrap items-center gap-1">
                        @foreach ($post->tags as $tags)
                            <a href="{{ route('tag.post', ['tag' => $tags->name]) }}"
                                class="text-xs font-semibold px-2 py-1 rounded-full bg-placeholder hover:bg-placeholder/50 transition">#{{ $tags->name }}</a>
                        @endforeach
                    </div>
                    <p class="mt-2 line-clamp-3 leading-6 text-base text-foreground2">
                        {{ $post->description }}
                    </p>
                </div>
            </article>
        @endforeach
    </div>
    {{ $posts->links() }}
</div>
