<?php

namespace App\Livewire\Medicine;

use App\Models\Category;
use App\Models\Medicine;
use App\Models\Supplier;
use App\Models\Unit;
use Livewire\Component;

class EditMedicine extends Component
{

    public $units;

    public $categories;
    public $filter_unit;
    public $suppliers;
    public $filter_category;
    public $filter_expired;
    // public $medicines;
    public $selectedMedicine;
    public $medicine;

    public $id, $name, $stock, $storage, $expired, $description, $purchase_price, $selling_price, $unit_id, $category_id, $supplier_id;
    public function mount(Medicine $medicine){

        $this->id = $medicine->id;
        $this->name = $medicine->name;
        $this->stock = $medicine->stock;
        $this->storage = $medicine->storage;
        $this->expired = $medicine->expired;
        $this->description = $medicine->description;
        $this->purchase_price = $medicine->purchase_price;
        $this->selling_price = $medicine->selling_price;
        $this->unit_id= $medicine->unit_id;
        $this->category_id = $medicine->category_id;
        $this->supplier_id = $medicine->supplier_id;

    }
    public function render()
    {

        $this->units = Unit::all();
        $this->categories = Category::all();
        $this->suppliers = Supplier::all();
        return view('livewire.medicine.edit-medicine');
    }

    public function editMedicine() {

        $this->validate([
            'name' => 'required|string|max:250',
            'stock' => 'required|integer|min_digits:1|max_digits:1000000',
            'storage' => 'nullable|string|max:250',
            'expired' => 'required|date_format:Y-m-d|max:250',
            'description' => 'nullable|string|max:250',
            'purchase_price' => 'required|integer|min_digits:2|max_digits:250',
            'selling_price' => 'required|integer|min_digits:2|max_digits:250',
            'unit_id' => 'required|integer|exists:App\Models\Unit,id',
            'category_id' => 'required|integer|exists:App\Models\Category,id',
            'supplier_id' => 'required|integer|exists:App\Models\Supplier,id',
        ],
        [
            'name.required'=> 'must input',
            'stock.required'=> 'must input',
            'storage.required'=> 'must input',
            'expired.required'=> 'must input',
            'description.required'=> 'must input',
            'purchase_price.required'=> 'must input',
            'selling_price.required'=> 'must input',
            'unit_id.required'=> 'must input',
            'categroy_id.required'=> 'must input',
            'supplier_id.required'=> 'must input',

        ]);


        $medicine = Medicine::find($this->id);
    $medicine->update([

    'name' => $this->name,
    'stock' => $this->stock,
    'storage' => $this->storage,
    'expired' => $this->expired,
    'description' => $this->description,
    'purchase_price' => $this->purchase_price,
    'selling_price' => $this->selling_price,
    'unit_id' => $this->unit_id,
    'category_id' => $this->category_id,
    'supplier_id' => $this->supplier_id,

    ]);

    $this->reset();
    $this->redirect('/medicines', navigate: true);
    $this->dispatch('notify', ['message' => 'Medicine Has Been Update!', 'status' => 'success']);

    }

    public function clearForm(){

        $this->reset('name', 'stock', 'storage', 'expired', 'description', 'purchase_price', 'selling_price', 'unit_id', 'category_id', 'supplier_id' );
    }


}
