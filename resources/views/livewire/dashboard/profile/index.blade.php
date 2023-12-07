<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin')] #[Title('Profile')] class extends Component {
    #[Rule('string|min:3|max:255')]
    public string $username;

    #[Rule('email|min:3|max:255')]
    public string $email;

    public function mount()
    {
        $this->username = auth()->user()->name;
        $this->email = auth()->user()->email;
    }

    public function update()
    {
        $this->validate();
        auth()
            ->user()
            ->update([
                'name' => $this->username,
                'email' => $this->email,
            ]);
    }

    public function with()
    {
        return [
            'username' => $this->username,
            'email' => $this->email,
        ];
    }
}; ?>

<div class="w-full">
    <h2>Profile</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 my-10">
        <form wire:submit="update" class="w-full flex flex-col gap-4">
            <div class="w-full">
                <h4 class="mb-4">Username</h4>
                <input type="text" wire:model="username" value="{{ $username }}"
                    class="block w-full px-2 bg-background border-2 border-placeholder focus:ring-0 hover:border-foreground2 focus:border-foreground2 focus:outline-none rounded-md @error('username') border-ancent @enderror ">
            </div>
            <div class="w-full">
                <h4 class="mb-4">Email</h4>
                <input type="email" wire:model="email" value="{{ $email }}"
                    class="block w-full px-2 bg-background border-2 border-placeholder focus:ring-0 hover:border-foreground2 focus:border-foreground2 focus:outline-none rounded-md @error('email') border-ancent @enderror ">
            </div>
            <div>
                <button type="submit" wire:dirty class="bg-ancent hover:bg-ancent-hover rounded-md px-8 py-4">Update</button>
            </div>
        </form>
        <div>
            <h4 class="mb-8">Password</h4>
            <a href="{{ route('dashboard.profile.password') }}" class="bg-ancent hover:bg-ancent-hover rounded-md px-8 py-4" wire:navigate>Ubah Password</a>
        </div>
    </div>
