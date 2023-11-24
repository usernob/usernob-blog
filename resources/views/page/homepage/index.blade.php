<x-layouts.guest>
    <x-slot:title>Home Page</x-slot:title>
    <header class="container my-4">
        <section class="w-full h-fit static md:flex md:flex-row-reverse md:gap-8 justify-between items-center my-16">
            <div>
                <img src="{{ asset('img/demure-windows-with-code.png') }}" alt="code"
                    class="w-full h-full mb-8 md:mb-0 xl:h-96">
            </div>
            <div class="flex flex-col gap-1 items-center text-center md:items-start md:text-start md:w-1/2">
                <h4><span class="text-ancent">Halo semua,</span> selamat datang di</h4>
                <h1 class="my-2 font-bold">USERNOB <span class="text-ancent">BLOG</span></h1>
                <h4 class="font-light">Berbagi berbagai macam tutorial tentang dunia programming dan linux, Mostly
                    berdasarkan pengalaman pribadi penulis</h4>
                <a class="py-4 px-8 mt-4 text-white rounded-md bg-ancent hover:bg-ancent-hover w-fit" href="/blog">
                    Mulai Belajar
                </a>
            </div>
        </section>
    </header>
    <section class="container my-4">
        <h3 class="text-ancent" id="latest-post">Post Terbaru</h3>
        <p class="mb-4">Mari cek post terbaru dari blog ini.</p>
        <livewire:component.homepage.latestpost lazy />
    </section>
</x-layouts.guest>
