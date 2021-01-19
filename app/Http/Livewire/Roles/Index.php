<?php

namespace App\Http\Livewire\Roles;

use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    
    public $search;
    
    /**
     * function to render the livewire view
     * 
     * @return Illuminate\View\View
     */
    public function render()
    {
        $roles = Role::with('permissions')->with('users')->where('title', 'like', '%' . $this->search . '%')->paginate(25);
        
        return view('livewire.roles.index', compact('roles'));
    }
}
