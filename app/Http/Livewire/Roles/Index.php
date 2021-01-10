<?php

namespace App\Http\Livewire\Roles;

use App\Models\Role;
use Livewire\Component;

class Index extends Component
{
    public $search;
    
    /**
     * function to render the livewire view
     * 
     * @return Illuminate\View\View
     */
    public function render()
    {
        $roles = Role::with('permissions')->with('users')->where('title', 'like', '%' . $this->search . '%')->get();
        
        return view('livewire.roles.index', compact('roles'));
    }
}
