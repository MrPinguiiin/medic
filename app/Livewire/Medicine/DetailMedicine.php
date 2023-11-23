<?php

namespace App\Livewire\Medicine;

use App\Models\Category;
use App\Models\Medicine;
use App\Models\Supplier;
use App\Models\Unit;
use Livewire\Component;

class DetailMedicine extends Component
{

    public  $medicine;

    public function mount(Medicine $medicine){

        $this->medicine = $medicine->load('unit', 'supplier', 'category');

    }
    public function render()
    {

        return view('livewire.medicine.detail-medicine');

    }


}
