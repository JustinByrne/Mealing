<?php

namespace App\Http\Livewire\Meals;

use Auth;
use Livewire\Component;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Validator;

class Create extends Component
{
    public $quantity;
    public $query;
    public $ingredients;
    public $ingredientId;
    public $autocomplete;
    public $ids;
    public $inputs;
    public $i;

    protected $rules = [
        'quantity' => 'required',
        'query' => 'required',
        'ingredientId' => 'required|numeric'
    ];

    /**
     * setting up variable deafults
     * 
     * @return void
     */
    public function mount()
    {
        $this->resetQuery();
        $this->inputs = array();
        $this->i = 0;
        $this->ids = array();
    }

    /**
     * reseting query variables
     * 
     * @return void
     */
    public function resetQuery()
    {
        $this->query = '';
        $this->quantity = '';
        $this->ingredients = array();
        $this->ingredientId = '';
        $this->autocomplete = false;
    }

    /**
     * getting the view
     * 
     * @return view
     */
    public function render()
    {
        return view('livewire.meals.create');
    }

    /**
     * adding all input values to array
     * 
     * @return array
     */
    public function add($i)
    {
        $this->validate();

        $this->inputs[$i]['quantity'] = $this->quantity;
        $this->inputs[$i]['ingredient'] = $this->query;
        $this->inputs[$i]['ingredientIds'] = $this->ingredientId;

        array_push($this->ids, $this->ingredientId);

        $this->i = $i + 1;

        $this->resetQuery();
    }

    /**
     * removing inputs from the array
     * 
     * @return void
     */
    public function remove($i)
    {
        if (($key = array_search($this->inputs[$i]['ingredientIds'], $this->ids)) !== false)  {
            unset($this->ids[$key]);
        }
        
        unset($this->inputs[$i]);
    }

    /**
     * get all the ingredients from the query
     * 
     * @return void
     */
    public function updatedQuery()
    {
        if ($this->query != '') {
            $this->autocomplete = false;
            $this->ingredients = Ingredient::where('name', 'like', '%' . $this->query . '%')->whereNotIn('id', $this->ids)->get()->toArray();
        } else {
            $this->ingredients = array();
        }
    }

    /**
     * change query and ingredientId value on selection
     * 
     * @return void
     */
    public function autocomplete($query, $id)
    {
        $this->query = $query;
        $this->ingredientId = $id;
        $this->autocomplete = true;
    }

    /**
     * create an ingredient if it doesn't exist
     * 
     * @return void
     */
    public function createIngredient()
    {
        $this->validate([
            'query' => 'required|unique:App\Models\Ingredient,name',
        ]);
        
        Auth::User()->Ingredients()->create([
            'name' => $this->query
        ]);

        $this->updatedQuery();
    }
}
