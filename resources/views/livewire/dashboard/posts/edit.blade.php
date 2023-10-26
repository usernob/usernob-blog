<?php

use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new class () extends Component {
    #[Layout('components.layouts.admin')]
    #[Title('Post Edit')]
    public $id = '';

    public function placeholder()
    {
        return <<<'HTML'
            <div class="w-full grid grid-cols-5 gap-4 animate-pulse">
                <div class="h-6 bg-background rounded col-span-2"></div>
                <div class="h-6 bg-background rounded col-span-2"></div>
                <div class="h-6 bg-background rounded col-span-1"></div>
                <div class="h-6 bg-background rounded col-span-3"></div>
                <div class="h-6 bg-background rounded col-span-2"></div>
                <div class="h-6 bg-background rounded col-span-2"></div>
            </div>
        HTML;
    }

    public function with()
    {
        return [
            'post' => Post::find($this->id),
        ];
    }
}; ?>

<article class="h-full relative" x-data="{ preview: false }">
    <script>
        document.addEventListener("alpine:init", () => {
            const content = document.getElementById("content");
            Alpine.data("content", () => ({
                contentHTML() {
                    return axios
                        .get("{{ asset($post->content) }}")
                        .then((res) => {
                            return marked.parse(res.data)
                        })
                        .catch((err) => {
                            console.log(err);
                            return err;
                        });
                },
            }));
        })
    </script>
    <button class="absolute botton-4 right-4 bg-ancent p-2 rounded-full" @click.prevent="preview = !preview">
        <div class="w-6 h-6 relative">
            <svg x-cloak x-show="preview" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="absolute inset-0">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>

            <svg x-cloak x-show="!preview" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="absolute inset-0">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>
        </div>
    </button>
</article>
