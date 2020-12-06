<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Meal;

class Comments extends Component
{
    public Meal $meal;
    public $comment;

    protected $rules = [
        'comment' => 'required'
    ];
    
    public function render()
    {
        return view('livewire.comments', [
            'meal' => $this->meal,
        ]);
    }

    public function addComment()
    {
        $this->validate();

        $this->meal->comments()->create([
            'comment' => $this->comment,
            'user_id' => \Auth::Id(),
        ]);
    }
}
