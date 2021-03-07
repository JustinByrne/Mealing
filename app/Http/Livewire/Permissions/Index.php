<?php

namespace App\Http\Livewire\Permissions;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

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
        $permissions = Permission::with('roles')->where('name', 'like', '%' . $this->search . '%')->orderBy('name')->paginate(25);
        
        return view('livewire.permissions.index', compact('permissions'));
    }
}
