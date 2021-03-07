<?php

namespace App\Http\Livewire\Roles;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

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
        $roles = Role::with('permissions')->with('users')->where('name', 'like', '%' . $this->search . '%')->paginate(25);
        
        return view('livewire.roles.index', compact('roles'));
    }
}
