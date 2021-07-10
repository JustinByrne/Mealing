<?php

namespace App\Http\Livewire;

use App\Models\Recipe;
use App\Models\Comment;
use Livewire\Component;

class Comments extends Component
{
    public Recipe $recipe;
    public $comment;

    protected $rules = [
        'comment' => 'required'
    ];
    
    public function render()
    {
        $this->recipe->load('comments.user');
        
        return view('livewire.comments', [
            'recipe' => $this->recipe,
        ]);
    }

    public function addComment()
    {
        $this->validate();

        $this->recipe->comments()->create([
            'comment' => $this->comment,
            'user_id' => \Auth::Id(),
        ]);

        $this->comment = '';
    }

    public function deleteComment($id)
    {
        Comment::find($id)->delete();
    }
}
