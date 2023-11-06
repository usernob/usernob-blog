<x-layouts.app>
    <x-slot:title>{{ $title ?? 'Dashboard' }}</x-slot:title>
    <x-slot:head>{{ $head ?? '' }}</x-slot:head>
    <livewire:component.dashboard.admin-navbar/>
    <main class="container mt-6">
        {{ $slot }}
    </main>
</x-layouts.app>
