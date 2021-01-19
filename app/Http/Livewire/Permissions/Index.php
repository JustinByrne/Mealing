<?php

namespace App\Http\Livewire\Permissions;

use Livewire\Component;
use App\Models\Permission;

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
        $permissions = Permission::with('roles')->where('title', 'like', '%' . $this->search . '%')->get();
        
        return view('livewire.permissions.index', compact('permissions'));
    }
}
