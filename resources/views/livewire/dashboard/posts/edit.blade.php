<?php

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
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

    private Post $post;

    public $searchTag = '';

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

    public function boot()
    {
        $this->post = Post::find($this->id);
    }

    public function mount()
    {
        $this->title = $this->post->title;
        $this->description = $this->post->description;
        $this->tag = json_encode($this->post->tags->pluck('name', 'id')->toArray());
    }

    public function update()
    {
        $this->validate();
        $data = [
            'title' => $this->title,
            'description' => $this->description,
        ];

        $tags = json_decode($this->tag, true);

        if ($this->thumbnail) {
            $data['thumbnail'] = $this->thumbnail->store('thumbnail');
            Storage::delete($this->post->thumbnail);
        }

        $path = "content/{$this->title}-" . date('Ymd-His') . '.md';
        // dd($this->content, $this->title);
        if ($this->content) {
            if (Storage::put($path, $this->content)) {
                $data['content'] = $path;
                Storage::delete($this->post->content);
            }
        }

        $this->post->tags()->sync(array_keys($tags));

        $this->post->update($data);
        session()->flash('status:success', 'Post updated successfully');
        return redirect()->route('dashboard.posts');
    }

    public function deletePost()
    {
        $this->post->delete();

        Storage::delete($this->post->thumbnail);
        Storage::delete($this->post->content);

        session()->flash('status:success', 'Post deleted successfully');
        return redirect()->route('dashboard.posts');
    }

    public function with()
    {
        return [
            'post' => $this->post,
            'tags' => $this->tags(),
        ];
    }
}; ?>

<form class="h-full relative mb-20" wire:submit="update">

    <div class="flex flex-col gap-4 justify-center items-center fixed right-10 bottom-10 z-[80]">
        <button type="submit" class="rounded-full p-2 bg-ancent text-background2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-10 h-10">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </button>

        <button type="button" wire:click="deletePost" class="rounded-full p-2 bg-ancent text-background2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-10 h-10">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
            </svg>
        </button>
    </div>

    <section class="w-full flex flex-col gap-4 rounded-md shadow-lg bg-background2 p-4" x-data="metadata">
        <div>
            @if($errors->any())
            <span class="text-red-500">{{ $errors->first() }}</span>
            @endif
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
        <div class="relative" x-init="fillTags">
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

                <img @if ($thumbnail) src="{{ $thumbnail->temporaryUrl() }}" @else src="{{ asset($post->thumbnail) }}" @endif
                    data-src="{{ asset($post->thumbnail) }}"
                    class="absolute top-0 left-0 w-full aspect-video object-cover object-center rounded-md group-hover:z-10">
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
            <button type="button" class="w-full py-2 rounded-t-md bg-background"
                :class="{ 'bg-background2': preview }" @click="renderPreview">
                <h5>Preview</h5>
            </button>
        </div>
        <div class="rounded-md shadow-lg bg-background2 p-4">

            <div class="w-full" x-show="!preview">
                <textarea
                    class="w-full rounded-md border-2 focus:ring-ancent focus:border-ancent bg-background2 placeholder:text-lg text-lg overflow-y-hidden"
                    name="content" id="content" rows="17" x-ref="content" data-src="{{ asset($post->content) }}"
                    wire:model="content" @input="resizeTextArea"></textarea>
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
                tags: [],

                fillTags() {
                    this.tags = JSON.parse(this.$refs.inputTag.value);
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
                deleteTag(index) {
                    delete this.tags[index]
                    this.updateInput();
                }
            }))
            Alpine.data("content", () => ({
                init() {
                    return axios
                        .get(this.$refs.content.dataset.src)
                        .then((res) => {
                            this.$refs.content.value = res.data
                            this.$refs.content.dispatchEvent(new Event("input"));
                            this.resizeTextArea();
                            return res;
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
                },
                resizeTextArea() {
                    this.$refs.content.style.height = "auto";
                    this.$refs.content.style.height = this.$refs.content.scrollHeight + "px";
                }
            }))
        })
    </script>
</form>
