<?php

namespace App\Livewire;

use Livewire\Component;

class WebLog extends Component
{
    public function render()
    {
        $filePath = storage_path('app/interact.log');

        // Check if the file exists
        if (file_exists($filePath)) {
            $fileContents = file_get_contents($filePath);
        } else {
            abort(404, 'Log file not found');
        }

        return view('livewire.web-log', ['fileContents' => $fileContents]);
    }
}
