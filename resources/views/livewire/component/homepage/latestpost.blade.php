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
            'posts' => Post::latest()->limit(6)->get(),
        ];
    }
}; ?>

<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 auto-cols-fr auto-rows-max w-full mb-8">
        @foreach ($posts as $post)
           <livewire:component.postcard :post="$post"/>
        @endforeach
    </div>
</div>
