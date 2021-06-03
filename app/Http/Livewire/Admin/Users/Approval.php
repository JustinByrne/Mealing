<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;

class Approval extends Component
{
    public User $user;
    
    public function render()
    {
        return view('livewire.admin.users.approval');
    }

    public function approve(): Void
    {
        $this->user->approve;
    }
}
