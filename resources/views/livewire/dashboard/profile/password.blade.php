<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin')] #[Title('Ubah Password')] class extends Component {
    #[Rule('required|current_password|min:8')]
    public string $oldpassword = '';

    #[Rule('required|min:8|confirmed')]
    public string $newpassword = '';

    #[Rule('required|min:8')]
    public string $newpassword_confirmation = '';

    public function update() {
        if($this->validate()) {
            auth()->user()->update([
                'password' => bcrypt($this->newpassword),
            ]);
            return redirect()->route('dashboard.profile');
        }
    }
}; ?>

<div class="w-full md:w-2/3 lg:w-1/3 bg-background2 rounded-xl p-4 m-auto">
    <h2 class="text-center">Ubah Password</h2>
    <form wire:submit="update" class="flex flex-col gap-4 my-10">
        <div>
            <h5 class="mb-2">Password Lama</h5>
            <input type="text" wire:model="oldpassword"
                class="block w-full px-2 bg-background border-2 border-placeholder focus:ring-0 hover:border-foreground2 focus:border-foreground2 focus:outline-none rounded-md @error('oldpassword') border-ancent @enderror ">
            @error('oldpassword')
                <p class="text-red-500 text-sm">{{ $errors->first('oldpassword') }}</p>
            @enderror
        </div>
        <div>
            <h5 class="mb-2">Password Baru</h5>
            <input type="text" wire:model="newpassword"
                class="block w-full px-2 bg-background border-2 border-placeholder focus:ring-0 hover:border-foreground2 focus:border-foreground2 focus:outline-none rounded-md @error('newpassword') border-ancent @enderror ">
            @error('newpassword')
                <p class="text-red-500 text-sm">{{ $errors->first('newpassword') }}</p>
            @enderror
        </div>
        <div>
            <h5 class="mb-2">Masukkan Kembali Password Baru</h5>
            <input type="text" wire:model="newpassword_confirmation"
                class="block w-full px-2 bg-background border-2 border-placeholder focus:ring-0 hover:border-foreground2 focus:border-foreground2 focus:outline-none rounded-md @error('newpassword_confirmation') border-ancent @enderror ">
            @error('newpassword_confirmation')
                <p class="text-red-500 text-sm">{{ $errors->first('newpassword_confirmation') }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-ancent hover:bg-ancent-hover rounded-md px-8 py-4">Update</button>
    </form>
</div>
