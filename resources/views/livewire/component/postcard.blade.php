<?php

use App\Models\Post;
use Livewire\Volt\Component;

new class () extends Component {
    public Post $post;
    public bool $showDescription;

    public function mount(Post $post, bool $showDescription = true)
    {
        $this->post = $post;
        $this->showDescription = $showDescription;
    }

    public function width()
    {
        return [
            'post' => $this->post,
            'showDescription' => $this->showDescription,
        ];
    }
}; ?>

<article class="group" wire:key="{{ $post->id }}">
    <div class="aspect-video w-full rounded-xl object-cover shadow-xl overflow-hidden">

        <img alt="{{ $post->title }}" src="{{ asset($post->thumbnail) }}"
            class="object-cover w-full h-full transition duration-300 ease-in-out group-hover:scale-105" loading="lazy" />
    </div>
    <div class="mt-4">
        <time datetime="{{ $post->created_at }}" class="block text-xm text-foreground2">
            {{ date('M d, Y', strtotime($post->created_at)) }}
        </time>
        <a href="{{ route('post.show', ['by' => 'id', 'param' => $post->id]) }}" class="block">
            <h4 class="text-foreground group-hover:text-ancent transition duration-300 ease-in-out mb-3 font-bold">
                {{ $post->title }}
            </h4>
        </a>
        <div class="flex flex-wrap items-center gap-1">
            @foreach ($post->tags as $tags)
                <a href="{{ route('tag.post', ['tag' => $tags->name]) }}"
                    class="text-xs font-semibold px-2 py-1 rounded-full bg-placeholder hover:bg-placeholder/50 transition">#{{ $tags->name }}</a>
            @endforeach
        </div>
        @if ($showDescription)
            <p class="mt-2 line-clamp-3 leading-6 text-base text-foreground2">
                {{ $post->description }}
            </p>
        @endif
    </div>
</article>
