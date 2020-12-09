<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Ingredient;

class Ingredients extends Component
{
    public $search;
    
    public function render()
    {
        if (request()->routeIs('ingredients.index'))    {
            return view('livewire.ingredients', [
                'ingredients' => \Auth::User()->Ingredients()->where('name', 'like', '%' . $this->search . '%')->get(),
            ]);
        } else {
            return view('livewire.ingredients', [
                'ingredients' => Ingredient::where('name', 'like', '%' . $this->search . '%')->get(),
            ]);
        }
    }
}
