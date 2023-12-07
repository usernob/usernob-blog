<?php

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin')] #[Title('Overview')] class extends Component {
    public Collection $post;
    public Carbon $startOfMonth;

    public function mount()
    {
        $this->post = Post::all();
        $this->startOfMonth = Carbon::now()->startOfMonth();
    }

    public function abbreviate(int $value, int $precision = 2): string
    {
        if ($value < 1000) {
            return (string) $value;
        }
        return Number::abbreviate($value, precision: $precision);
    }

    public function with(): array
    {
        return [
            'total_post' => $this->abbreviate($this->post->count()),
            'total_post_this_month' => $this->abbreviate($this->post->where('created_at', '>=', $this->startOfMonth)->count()),
            'total_viewers' => $this->abbreviate($this->post->sum('total_view_count')),
            'total_viewers_this_month' => $this->abbreviate($this->post->where('created_at', '>=', $this->startOfMonth)->sum('thismonth_view_count')),
            'total_tag' => $this->abbreviate(Tag::all()->count()),
            'popular_post_this_month' => $this->post
                ->where('created_at', '>=', $this->startOfMonth)
                ->sortByDesc('thismonth_view_count')
                ->take(10),
            'popular_post' => $this->post->sortByDesc('total_view_count')->take(10),
        ];
    }
}; ?>

<div>
    <h2>Overview</h2>

    <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4 mb-10">
        <div class="px-4 py-8 rounded-xl bg-green-500 text-black flex gap-4 items-center w-full justify-start">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
            </svg>
            <div class="w-fit">
                <h5 class="text-3xl">Total Post</h5>
                <div class="flex justify-start items-start">
                    <h1 class="text-7xl font-bold mr-4">{{ $total_post }}</h1>
                    <h2>+ {{ $total_post_this_month }}</h2>
                </div>
            </div>
        </div>

        <div class="px-4 py-8 rounded-xl bg-yellow-500 text-black flex gap-4 items-center w-full justify-start">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <div class="w-fit">
                <h5 class="text-3xl">Total Viewers</h5>
                <div class="flex flex-wrap justify-start items-start">
                    <h1 class="text-5xl md:text-7xl font-bold mr-4">{{ $total_viewers }}</h1>
                    <h2>+ {{ $total_viewers_this_month }}</h2>
                </div>
            </div>
        </div>
        <div class="px-4 py-8 rounded-xl bg-blue-500 text-black flex gap-4 items-center w-full justify-start">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5l-3.9 19.5m-2.1-19.5l-3.9 19.5" />
            </svg>
            <div class="w-fit">
                <h5 class="text-3xl">Total Tag</h5>
                <div class="flex justify-start items-start">
                    <h1 class="text-7xl font-bold mr-4">{{ $total_tag }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-24">
        <div>
            <h2>Post Populer Bulan Ini</h2>
            <ul class="flex flex-col gap-2 mt-4">
                @foreach ($popular_post_this_month as $post)
                    <li class="flex items-center justify-between w-full gap-8 group">
                        <p>{{ $loop->iteration }}.</p>
                        <h4 class="truncate w-full group-hover:text-ancent"><a
                                href="{{ route('dashboard.posts.edit', ['id' => $post->id]) }}">{{ $post->title }}</a>
                        </h4>
                        <p class="w-60 group-hover:text-ancent text-foreground2">
                            {{ $post->created_at->diffForHumans() }}</p>
                        <div class="w-20 flex justify-start items-center gap-2">
                            <p class="group-hover:text-ancent">{{ $this->abbreviate($post->thismonth_view_count) }}</p>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 group-hover:text-ancent">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div>
            <h2>Post Paling Populer</h2>
            <ul class="flex flex-col gap-2 mt-4">
                @foreach ($popular_post as $post)
                    <li class="flex items-center justify-between w-full gap-8 group">
                        <p>{{ $loop->iteration }}.</p>
                        <h4 class="truncate w-full group-hover:text-ancent"><a
                                href="{{ route('dashboard.posts.edit', ['id' => $post->id]) }}">{{ $post->title }}</a>
                        </h4>
                        <p class="w-60 group-hover:text-ancent text-foreground2">
                            {{ $post->created_at->diffForHumans() }}</p>
                        <div class="w-20 flex justify-start items-center gap-2">
                            <p class="group-hover:text-ancent">{{ $this->abbreviate($post->total_view_count) }}</p>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 group-hover:text-ancent">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
