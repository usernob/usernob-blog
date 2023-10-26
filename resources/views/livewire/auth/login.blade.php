<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new class () extends Component {
    #[Title("Login")]

    #[Locked]
    private int $id;

    #[Rule('required|email|max:255')]
    public string $email = '';

    #[Rule('required|max:255')]
    public string $password = '';

    public function boot()
    {
        if (Auth::check()) {
            return redirect()->intended(route('dashboard.overview'));
        }
    }

    public function submit()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            return redirect()->intended(route('dashboard.overview'));
        }
        $this->addError('email', 'email atau password salah');
    }
}; ?>

<section class="w-full flex justify-center items-center h-screen">
    <form wire:submit="submit" class="flex flex-col gap-4 p-4 items-center w-3/4 max-w-md">
        @csrf
        <h3>Selamat Datang Kembali</h3>
        <p class="leading-6 mb-10">Siap Menulis sesuatu yang menarik?</p>
        <div class="w-full">
            <label for="email" class="text-lg">Email</label>
            <input type="email" id="email" name="email" wire:model.live.debounce.500ms="email" required
                class="block w-full px-0.5 bg-background border-0 border-b-2 border-placeholder focus:ring-0 hover:border-foreground2 focus:border-foreground2 focus:outline-none @error('email') border-ancent @enderror "
                placeholder="Masukkan Email" />
            @error('email')
                <p class="text-red-500 text-sm">{{ $errors->first('email') }}</p>
            @enderror
        </div>
        <div class="w-full">
            <label for="password" class="text-lg">Password</label>
            <div class="w-full flex border-b-2 border-placeholder hover:border-foreground2 focus:border-foreground2 @error('password') border-ancent @enderror"
                x-data="{ show: false }">
                <input :type="show ? 'text' : 'password'" id="password" name="password"
                    wire:model.live.debounce.500ms="password" required
                    class="block w-full px-0.5 bg-background border-0 focus:outline-none focus:ring-0"
                    placeholder="Masukkan Password" />
                <button type="button" class="mr-2" @click="show = !show">
                    <svg x-cloak x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                    <svg x-cloak x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="text-red-500 text-sm">{{ $errors->first('password') }}</p>
            @enderror
        </div>
        <button type="submit" class="py-2 bg-ancent hover:bg-ancent_alt text-white w-full rounded-sm my-10 text-lg">
            Log In
        </button>
    </form>
</section>
