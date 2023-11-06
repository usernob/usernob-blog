<?php

use App\Models\Post;
use App\Models\Tag;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class () extends Component {
    use WithFileUploads;

    #[Layout('components.layouts.admin')]
    #[Title('Post Edit')]

    public $id = '';

    public $searchTag = '';


    public $title = '';
    public $description = '';
    public $tag = '';
    public $thumbnail;
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

    public function searchTag($query)
    {
        $this->searchTag = $query;
    }

    public function tags()
    {
        if ($this->searchTag == '') {
            return [];
        }
        return Tag::where('name', 'like', '%' . $this->searchTag . '%')->get();
    }
    public function with()
    {
        return [
            'post' => Post::find($this->id),
            'tags' => $this->tags(),
        ];
    }
}; ?>

<article class="h-full relative">

    <section class="w-full flex flex-col gap-4 rounded-md shadow-lg bg-background2 p-4" x-data="metadata">
        <div>
            <label for="title">
                <h4 class="mb-2">Title</h4>
            </label>
            <input class="w-full rounded-md border-2 focus:ring-ancent focus:border-ancent" type="text" name="title"
                id="title" wire:model="title">
        </div>
        <div>
            <label for="description">
                <h4 class="mb-2">Description</h4>
            </label>
            <textarea class="w-full rounded-md border-2 focus:ring-ancent focus:border-ancent" name="description" id="description"
                rows="6" wire:model="description"></textarea>
        </div>
        <input type="text" x-ref="inputTag" name="tag" wire:model="tag" hidden>
        <div class="relative">
            <label for="tag">
                <h4 class="mb-2">Tags</h4>
            </label>
            <input class="w-full rounded-md border-2 focus:ring-ancent focus:border-ancent" type="search"
                x-ref="taginputmodel" id="tag" wire:model.live.debounce.500ms="searchTag">
            @if (count($tags) > 0)
                <div
                    class="absolute left-0 top-20 flex flex-col bg-background2 items-start rounded-md shadow-md w-full">
                    @foreach ($tags as $tag)
                        <button class="w-full text-xl hover:bg-opacity-50 text-start hover:bg-background px-[0.75rem]"
                            @click="addTag">{{ $tag->name }}</button>
                    @endforeach
                </div>
            @endif
            <div class="w-full flex flex-wrap gap-2 mt-4">
                <template x-for="(tag, index) in tags" :key="index">
                    <div class="bg-ancent rounded-full px-4 py-2 flex items-center gap-2 text-background2">
                        <p x-text="tag"></p>
                        <button @click="deleteTag" x-bind:data-tag="tag">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>
        <div>
            <label for="thumbnail">
                <h4 class="mb-2">Thumbnail</h4>
            </label>
            <div x-init="checkImg"
                class="relative flex flex-col items-center justify-center
                border-dashed border-2 border-placeholder
                rounded-md gap-2 cursor-pointer transition ease-in-out hover:opacity-80 p-4
                aspect-video"
                id="dropcontainer" x-bind="handleDrag">
                <span class="text-xl">Drop files here</span>
                or
                <input type="file" name="thumbnail" id="thumbnail" x-ref="thumbnail" wire:model="thumbnail" accept="image/*">
                16:9 image only
                <img x-show="previewImg" x-ref="previewImg" src="{{ asset($post->thumbnail) }}"
                    data-src="{{ asset($post->thumbnail) }}"
                    class="absolute top-0 left-0 w-full aspect-video object-cover object-center rounded-md">
            </div>
        </div>
    </section>
    <section class="mt-10" x-data="content">
        <div class="flex">
            <button class="w-full py-2 rounded-t-md" :class="{ 'bg-background2': !preview }" @click="preview = false">
                <h5>Edit</h5>
            </button>
            <button class="w-full py-2 rounded-t-md" :class="{ 'bg-background2': preview }" @click="renderPreview">
                <h5>Preview</h5>
            </button>
        </div>
        <div class="rounded-md shadow-lg bg-background2 p-4">

            <div class="w-full" x-show="!preview">
                <textarea class="w-full rounded-md border-2 focus:ring-ancent focus:border-ancent" name="content" id="content"
                    rows="50" x-ref="content" data-src="{{ asset($post->content) }}"></textarea>
            </div>

            <div x-show="preview">
                <div
                    class="prose md:prose-xl dark:prose-invert mx-auto w-full max-w-[80ch] px-6 prose-img:mx-auto prose-img:rounded-xl prose-img:shadow-lg">
                    <div x-ref="previewContent">
                        <div class="w-full grid grid-cols-5 gap-4 animate-pulse">
                            <div class="h-6 bg-background rounded col-span-2"></div>
                            <div class="h-6 bg-background rounded col-span-2"></div>
                            <div class="h-6 bg-background rounded col-span-1"></div>
                            <div class="h-6 bg-background rounded col-span-3"></div>
                            <div class="h-6 bg-background rounded col-span-2"></div>
                            <div class="h-6 bg-background rounded col-span-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("metadata", () => ({
                previewImg: false,
                checkImg() {
                    if (this.$refs.previewImg.dataset.src) {
                        this.previewImg = true;
                    }
                },
                handleDrag: {
                    ['@dragover'](e) {
                        e.preventDefault();
                    },
                    ['@drop'](e) {
                        e.preventDefault();
                        this.$refs.thumbnail.files = e.dataTransfer.files
                        if (this.$refs.thumbnail.files.length > 0) {
                            this.previewImg = true;
                            let src = URL.createObjectURL(this.$refs.thumbnail.files[0]);
                            this.$refs.previewImg.src = src;
                        } else {
                            this.previewImg = false;
                        }
                    }
                },
                tags: [],

                updateInput() {
                    this.$refs.inputTag.value = this.tags.join(",");
                    this.$refs.inputTag.dispatchEvent(new Event("input"));
                },
                addTag(e) {
                    this.$refs.taginputmodel.value = null;
                    this.$refs.taginputmodel.dispatchEvent(new Event("input"));
                    if (this.tags.includes(e.target.innerText)) return;
                    this.tags.push(e.target.innerText);
                    this.updateInput();
                },
                deleteTag(e) {
                    this.tags = this.tags.filter((tag) => tag !== e.target.parentElement.dataset.tag);
                    this.updateInput();
                }
            }))
            Alpine.data("content", () => ({
                init() {
                    return axios
                        .get(this.$refs.content.dataset.src)
                        .then((res) => {
                            return this.$refs.content.value = res.data
                        })
                        .catch((err) => {
                            console.log(err);
                            return err;
                        });
                },
                preview: false,
                async renderPreview(e) {
                    this.preview = true;
                    this.$refs.previewContent.innerHTML = await marked.parse(this.$refs.content
                        .value);
                }
            }))
        })
    </script>
</article>
