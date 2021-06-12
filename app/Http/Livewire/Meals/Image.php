<?php

namespace App\Http\Livewire\Meals;

use Livewire\Component;

class Image extends Component
{
    public $meal;

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];
    
    public function render()
    {
        return view('livewire.meals.image', [
            'meal' => $this->meal,
        ]);
    }

    public function delete()
    {
        $items = $this->meal->getMedia();

        foreach ($items as $item) {
            $item->delete();
        }

        $this->emit('refreshComponent');
    }
}
