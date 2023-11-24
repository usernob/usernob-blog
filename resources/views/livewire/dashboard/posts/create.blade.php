<?php

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class () extends Component {
    use WithFileUploads;

    #[Layout('components.layouts.admin')]
    #[Title('Post Create')]
    public $searchTag = '';

    #[Rule('required|min:5')]
    public $title = '';

    #[Rule('required')]
    public $description = '';

    #[Rule('required')]
    public $tag = '';

    #[Rule('required')]
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
            return null;
        }
        if ($this->searchTag == '*') {
            return Tag::all();
        }
        return Tag::where('name', 'like', '%' . $this->searchTag . '%')->get();
    }

    public function addNewTag()
    {
        $this->validate(['tag' => 'required']);
        Tag::firstOrCreate(['name' => $this->searchTag]);
        $this->searchTag = '';
        return;
    }


    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
        ];

        $tags = json_decode($this->tag, true);

        if ($this->thumbnail) {
            $data['thumbnail'] = $this->thumbnail->store('thumbnail');
        }

        $path = "content/{$this->title}-" . date('Ymd-His') . '.md';
        if (Storage::put($path, $this->content)) {
            $data['content'] = $path;
        }

        $post = Auth::user()
            ->posts()
            ->create($data);
        $post->tags()->attach(array_keys($tags));

        session()->flash('status:success', 'Post has been created');
        $this->redirectRoute('dashboard.posts');
    }

    public function with()
    {
        return [
            'tags' => $this->tags(),
        ];
    }
}; ?>

<form class="h-full relative mb-20" wire:submit="save">

    <button type="submit" class="fixed right-10 bottom-10 rounded-full p-2 z-[80] bg-ancent text-background2">
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
            <input
                class="w-full rounded-md border-2 focus:ring-ancent focus:border-ancent bg-background2 placeholder:text-ld text-lg"
                type="text" name="title" id="title" wire:model="title">
            @error('title')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="description">
                <h4 class="mb-2">Description</h4>
            </label>
            <textarea
                class="w-full rounded-md border-2 focus:ring-ancent focus:border-ancent bg-background2 placeholder:text-lg text-lg"
                name="description" id="description" rows="6" wire:model="description"></textarea>
        </div>
        <input type="text" x-ref="inputTag" name="tag" wire:model="tag" hidden>
        <div class="relative">
            <label for="tag">
                <h4 class="mb-2">Tags</h4>
            </label>
            <input
                class="w-full rounded-md border-2 focus:ring-ancent focus:border-ancent bg-background2 placeholder:text-lg text-lg"
                type="search" x-ref="taginputmodel" id="tag" wire:model.live.debounce.500ms="searchTag">
            @if ($tags != null)
                <div
                    class="absolute left-0 top-20 z-30 max-h-60 overflow-y-auto flex flex-col bg-background2 items-start rounded-md shadow-md w-full border-2 border-placeholder">
                    @foreach ($tags as $tag)
                        <button type="button"
                            class="w-full text-xl hover:bg-opacity-50 text-start hover:bg-background px-[0.75rem]"
                            @click="addTag" data-id="{{ $tag->id }}">{{ $tag->name }}</button>
                    @endforeach
                    <button type="button"
                        class="w-full text-xl hover:bg-opacity-50 bg-background text-start px-[0.75rem]"
                        wire:click="addNewTag">+ new tag</button>
                </div>
            @endif
            <div class="w-full flex flex-wrap gap-2 mt-4">
                <template x-for="tag, index in tags" :key="index">
                    <div class="bg-ancent rounded-full px-4 py-2 flex items-center gap-2 text-background2">
                        <p x-text="tag"></p>
                        <button type="button" @click="deleteTag(index)" x-bind:data-tag="index">
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
            <div class="relative flex flex-col items-center justify-center
                border-dashed border-2 border-placeholder
                rounded-md gap-2 cursor-pointer transition ease-in-out hover:opacity-80 group p-4
                aspect-video"
                id="dropcontainer" x-bind="handleDrag">
                <span class="text-xl">Drop files here</span>
                or
                <input type="file" name="thumbnail" id="thumbnail" x-ref="thumbnail" wire:model="thumbnail"
                    onchange="(e) => e.preventDefault()" accept="image/*" class="group-hover:z-20">
                16:9 image only
                @if ($thumbnail)
                    <img src="{{ $thumbnail->temporaryUrl() }}"
                        class="absolute top-0 left-0 w-full aspect-video object-cover object-center rounded-md group-hover:z-10">
                @endif
            </div>
            @error('thumbnail')
                <span>{{ $message }}</span>
            @enderror
        </div>
    </section>
    <section class="mt-10" x-data="content">
        <div class="flex sticky top-20">
            <button type="button" class="w-full py-2 rounded-t-md bg-background"
                :class="{ 'bg-background2': !preview }" @click="preview = false">
                <h5>Edit</h5>
            </button>
            <button type="button" class="w-full py-2 rounded-t-md bg-background" :class="{ 'bg-background2': preview }"
                @click="renderPreview">
                <h5>Preview</h5>
            </button>
        </div>
        <div class="rounded-md shadow-lg bg-background2 p-4">

            <div class="w-full" x-show="!preview">
                <textarea
                    class="w-full rounded-md border-2 focus:ring-ancent focus:border-ancent bg-background2 placeholder:text-lg text-lg overflow-y-hidden"
                    name="content" id="content" rows="17" x-ref="content" wire:model="content" @input="resizeTextArea"></textarea>
            </div>

            <div x-show="preview" class="w-full min-h-[50vh]">
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
                handleDrag: {
                    ['@dragover'](e) {
                        e.preventDefault();
                    },
                    ['@drop'](e) {
                        e.preventDefault();
                        this.$refs.thumbnail.files = e.dataTransfer.files
                        this.$refs.thumbnail.dispatchEvent(new Event("change"))
                    }
                },
                tags: {},

                // fillTags() {
                //     this.tags = JSON.parse(this.$refs.inputTag.value);
                // },
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
                deleteTag(index) {
                    delete this.tags[index]
                    this.updateInput();
                }
            }))
            Alpine.data("content", () => ({
                preview: false,
                async renderPreview(e) {
                    this.preview = true;
                    this.$refs.previewContent.innerHTML = await marked.parse(this.$refs.content
                        .value);
                },

                resizeTextArea() {
                    this.$refs.content.style.height = "auto";
                    this.$refs.content.style.height = this.$refs.content.scrollHeight + "px";
                }
            }))
        })
    </script>
</form>
