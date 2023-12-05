<x-layouts.app>
    <x-slot:title>{{ $title ?? 'Dashboard' }}</x-slot:title>
    <x-slot:head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
    </x-slot:head>
    <livewire:component.dashboard.admin-navbar/>
    <main class="container mt-6">
        {{ $slot }}
    </main>
</x-layouts.app>
