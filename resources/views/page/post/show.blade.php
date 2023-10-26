<x-layouts.guest>
    <x-slot:title>{{ $post->title }}</x-slot:title>
    <x-slot:head>
        @vite('resources/js/scripts/guest/post/getpost.js')
    </x-slot:head>
    <article class="h-full">
        <section class="bg-background w-full pt-10 lg:pt-20 pb-10 relative">
            <div class="bg-background2 w-full h-1/3 absolute bottom-0 inset-x-0"></div>
            <div class="prose md:prose-xl dark:prose-invert mx-auto w-full max-w-[80ch] px-6 relative z-10">
                <h2 class="mb-4 not-prose text-foreground">{{ $post->title }}</h2>
                <p class="not-prose text-sm lg:text-base text-foreground2/80 leading-5">{{ $post->description }}</p>
                <img src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}"
                    class="aspect-video rounded-lg shadow-xl w-full object-cover" loading="lazy">
            </div>
        </section>
        <section class="bg-background2">
            <div class="prose md:prose-xl dark:prose-invert mx-auto w-full max-w-[80ch] px-6 prose-img:mx-auto prose-img:rounded-xl prose-img:shadow-lg"
                x-data="content">
                <hr>
                <div id="content" data-src="{{ asset($post->content) }}" x-html="contentHTML">
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
        </section>
        <script>
            document.addEventListener("alpine:init", () => {
                const content = document.getElementById("content");
                Alpine.data("content", () => ({
                    contentHTML() {
                        return axios
                            .get(content.dataset.src)
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
    </article>
</x-layouts.guest>
