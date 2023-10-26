<x-layouts.app>
    <x-slot:title>{{ $title ?? 'Dashboard' }}</x-slot:title>
    <x-slot:head>{{ $head ?? '' }}</x-slot:head>
    <livewire:component.dashboard.admin-navbar/>
    <main class="container rounded-md shadow-lg bg-background2 mt-6 p-4">
        {{ $slot }}
    </main>
</x-layouts.app>
