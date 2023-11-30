<x-layouts.guest>
    <x-slot:title>Tag - {{ $tagname }}</x-slot:title>
    <section class="container min-h-screen my-10">
        <h3>Hasil dari Tag <span class="text-ancent">"{{ $tagname }}"</span></h3>
        <h5>Ditemukan {{ $posts->count() }} post</h5>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 auto-cols-fr auto-rows-max w-full mt-8">
            @foreach ($posts as $post)
                <livewire:component.postcard :post="$post" :showDescription="false" />
            @endforeach
        </div>
    </section>
</x-layouts.guest>
