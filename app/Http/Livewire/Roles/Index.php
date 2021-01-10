<?php

namespace App\Http\Livewire\Roles;

use App\Models\Role;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $roles = Role::with('permissions')->with('users')->get();
        
        return view('livewire.roles.index', compact('roles'));
    }
}
