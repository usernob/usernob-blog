<?php

use App\Models\Post;
use App\Models\Tag;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class () extends Component {
    use WithFileUploads;

    #[Layout('components.layouts.admin')]
    #[Title('Post Edit')]
    public $id = '';

    public $searchTag = '';
    private $posts;

    #[Rule('required|min:5')]
    public $title = '';

    #[Rule('required')]
    public $description = '';

    #[Rule('required')]
    public $tag = '';

    public $thumbnail;

    #[Rule('required')]
    public $content = '';

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

    private Post $post;

    public function boot()
    {
        $this->post = Post::find($this->id);
    }

    public function mount()
    {
        $this->title = $this->post->title;
        $this->description = $this->post->description;
        $this->tag = json_encode(
            $this->post
                ->tag_relation()
                ->with('tag')
                ->get()
                ->pluck('tag.name', "tag.id")
                ->toArray(),
        );
        $this->content = $this->post->content;
    }

    public function update()
    {
        $this->validate();
        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
        ];

        $tags = json_decode($this->tag, true);

        $this->post->tag_relation()->sync($tags);

        $this->post->update($data);
    }

    public function with()
    {
        return [
            'post' => $this->post,
            'tags' => $this->tags(),
        ];
    }
}; ?>

<form class="h-full relative" wire:submit="update">
    <button type="submit" class="fixed right-10 bottom-10 rounded-full p-2 z-10 bg-ancent text-background2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-10 h-10">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </button>
    <section class="w-full flex flex-col gap-4 rounded-md shadow-lg bg-background2 p-4" x-data="metadata">
        <div>
            <label for="title">
                <h4 class="mb-2">Title</h4>
            </label>
            <input class="w-full rounded-md border-2 focus:ring-ancent focus:border-ancent bg-background2"
                type="text" name="title" id="title" wire:model="title">
            @error('title')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="description">
                <h4 class="mb-2">Description</h4>
            </label>
            <textarea class="w-full rounded-md border-2 focus:ring-ancent focus:border-ancent bg-background2" name="description"
                id="description" rows="6" wire:model="description"></textarea>
        </div>
        <input type="text" x-ref="inputTag" name="tag" wire:model="tag" hidden>
        <div class="relative" x-init="fillTags">
            <label for="tag">
                <h4 class="mb-2">Tags</h4>
            </label>
            <input class="w-full rounded-md border-2 focus:ring-ancent focus:border-ancent bg-background2"
                type="search" x-ref="taginputmodel" id="tag" wire:model.live.debounce.500ms="searchTag">
            @if (count($tags) > 0)
                <div
                    class="absolute left-0 top-20 flex flex-col bg-background2 items-start rounded-md shadow-md w-full">
                    @foreach ($tags as $tag)
                        <button class="w-full text-xl hover:bg-opacity-50 text-start hover:bg-background px-[0.75rem]"
                            @click="addTag" data-id="{{ $tag->id }}">{{ $tag->name }}</button>
                    @endforeach
                </div>
            @endif
            <div class="w-full flex flex-wrap gap-2 mt-4">
                <template x-for="tag, index in tags" :key="index">
                    <div class="bg-ancent rounded-full px-4 py-2 flex items-center gap-2 text-background2">
                        <p x-text="tag"></p>
                        <button @click="deleteTag" x-bind:data-tag="index">
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
                <input type="file" name="thumbnail" id="thumbnail" x-ref="thumbnail" wire:model="thumbnail"
                    accept="image/*">
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
                <textarea class="w-full rounded-md border-2 focus:ring-ancent focus:border-ancent bg-background2" name="content"
                    id="content" rows="50" x-ref="content" data-src="{{ asset($post->content) }}" wire:model="content"></textarea>
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

                fillTags() {
                    this.tags = JSON.parse(this.$refs.inputTag.value);
                    console.log(JSON.parse(this.$refs.inputTag.value))
                },
                updateInput() {
                    this.$refs.inputTag.value = JSON.stringify(this.tags);
                    this.$refs.inputTag.dispatchEvent(new Event("input"));
                },
                addTag(e) {
                    this.$refs.taginputmodel.value = null;
                    this.$refs.taginputmodel.dispatchEvent(new Event("input"));
                    if (this.tags.hasOwnProperty(e.target.dataset.id)) return;
                    this.tags[e.target.dataset.id] = e.target.innerText
                    this.updateInput();
                },
                deleteTag(e) {
                    delete this.tags[e.target.parentElement.dataset.tag]
                    console.log(this.tags, e.target.parentElement.dataset.tag)
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
</form>
