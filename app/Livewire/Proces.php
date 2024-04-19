<?php

namespace App\Livewire;

use Livewire\Component;

class Proces extends Component
{
    public $nama = "SINDY";
    public function send()
    {
        dd($this);
    }

    public function render()
    {
        return view('livewire.proces');
    }
}
