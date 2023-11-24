<x-layouts.guest>
    <x-slot:title>Category</x-slot:title>
    <section class="container min-h-screen mt-10">
        <h2>Tag</h2>
        <h4>Cari post berdasarkan tag</h4>
        <div class="mt-10 flex flex-wrap gap-4">
            @foreach ($tags as $tag)
                <a href="{{ route('tag.post', $tag->name) }}" class="bg-ancent hover:bg-ancent-hover px-4 py-2 rounded-md text-foreground text-4xl">#{{ $tag->name }}  {{ $tag->posts->count() }}</a>
            @endforeach
        </div>
    </section>
</x-layouts.guest>
