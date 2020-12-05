<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Meal;

class Comments extends Component
{
    public Meal $meal;
    
    public function render()
    {
        return view('livewire.comments', [
            'comments' => $this->meal->comments,
        ]);
    }
}
