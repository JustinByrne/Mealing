<?php

namespace App\Http\Livewire\Permissions;

use Livewire\Component;
use App\Models\Permission;
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
        $permissions = Permission::with('roles')->where('title', 'like', '%' . $this->search . '%')->paginate(25);
        
        return view('livewire.permissions.index', compact('permissions'));
    }
}
