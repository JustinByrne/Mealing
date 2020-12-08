<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Ingredients extends Component
{
    public $ingredients;
    
    public function render()
    {
        return view('livewire.ingredients', [
            'ingredients' => $this->ingredients,
        ]);
    }
}
