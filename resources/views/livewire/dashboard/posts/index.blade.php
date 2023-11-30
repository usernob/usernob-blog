<?php

use App\Models\Post;
use Illuminate\Pagination\Paginator;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class () extends Component {
    use WithPagination;
    #[Layout('components.layouts.admin')]
    #[Title('Posts')]
    public $search = '';

    public function searchPost(string $query): Paginator
    {
        if (isset($query) && $query != '') {
            return Post::where('title', 'like', "%{$query}%")->simplePaginate(10);
        }
        return Post::orderBy('updated_at', 'desc')->simplePaginate(10);
    }

    public function with()
    {
        return [
            'posts' => $this->searchPost($this->search),
        ];
    }
}; ?>

<div class="rounded-md shadow-lg bg-background2 p-4 border border-slate-700">
    <h2>Posts</h2>
    <div class="flex gap-4 w-full mt-4">
        <div
            class="flex items-center rounded-md border border-slate-700 flex-1 hover:border-foreground focus:border-foreground overflow-hidden">
            <input type="text" class="w-full px-4 bg-background2 border-0 focus:ring-0 focus:outline-none"
                placeholder="Cari post" wire:model.live.debounce.500ms="search" />
            <button class="m-2 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </button>
        </div>
        <a href="{{ route('dashboard.posts.create') }}"
            class="rounded-md py-2 px-4 flex items-center bg-ancent hover:bg-ancent/80 focus:ring-2 focus:ring-foreground text-background2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Tambah
        </a>
    </div>

    @if (session('status:success'))
        <div class="w-full bg-green-600 rounded-md p-4 mt-10">
            <span>{{ session('status:success') }}</span>
        </div>
    @endif

    <div class="w-full flex flex-col gap-4 mt-10">
        @foreach ($posts as $post)
            <article class="flex flex-col md:flex-row w-full items-center gap-4 group">
                <img src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}"
                    class="rounded-md object-cover object-center bg-placeholder aspect-video w-full md:w-1/4 group-hover:opacity-80 transition duration-300 ease-in-out"
                    loading="lazy">
                <div class="flex-1 w-full md:w-3/4">
                    <a href="{{ route('dashboard.posts.edit', ['id' => $post->id]) }}">
                        <h4 class="group-hover:text-ancent transition duration-300 ease-in-out">{{ $post->title }}</h4>
                    </a>
                    <p class="text-base text-foreground2">{{ $post->description }}</p>
                </div>
            </article>
            <hr>
        @endforeach
        {{ $posts->links() }}
    </div>
</div>
