<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new class () extends Component {
    #[Layout('components.layouts.admin')]
    #[Title('Overview')]
    public function boot()
    {
        return 0;
    }
}; ?>

<div>
    <h2>Overview</h2>
</div>
