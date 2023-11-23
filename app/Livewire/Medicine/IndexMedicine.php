<?php

namespace App\Livewire\Medicine;

use Illuminate\Contracts\View\View;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Livewire\Component;
use App\Models\Medicine;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;


class IndexMedicine extends Component
{
    use WithPagination;

    #[Url(as : 'q')]
    public $search = '';

    protected $queryString = ['q'];
    public int $perPage = 10;
    public $units;
    public $med;
    public $cat;
    public $categories;
    public $filter_unit;
    public $filter_category;
    public $filter_expired;
    // public $medicines;
    public $selectedMedicine;
    public $selectedUnit;
    public $selectedCategory;

    public $total_purchase;
    public $purchases;
    public $ex;


    public function render() : View
    {
        $this->units = Unit::all();
        $this->categories = Category::all();
        $this->purchases = Purchase::all();
        $today = $this->filter_expired != null ? today()->format('Y-m-d') : '';

        return view('livewire.medicine.index-medicine',
        [
            'medicines' => Medicine::where('name', 'like', '%'.$this->search.'%')
            ->where('unit_id', 'like', '%'.$this->filter_unit. '%')
            ->where('category_id', 'like', '%'.$this->filter_category. '%')
            ->when($today != '', function ($q) use($today){
                return $this->filter_expired ? $q->whereDate('expired', '<=', $today) : $q->whereDate('expired', '>=', $today);
            })
            ->with('supplier', 'unit', 'category')
            ->latest()
            ->paginate($this->perPage)
        ]);
    }

    public function loadMore() : void
    {
        $this->perPage += 10;
    }


    public function deleteMedicine(array $medicine) : void
    {
        $this->selectedMedicine = $medicine;
        $this->dispatch('open-modal', 'delete-medicine');
    }


    public function editMedicine(array $medicine) : void
    {

        $this->selectedMedicine = $medicine;
        // $this->selectedMedicine['expired'] = $medicine['expired'];
        $this->ex = $medicine['expired'];
        $this->dispatch('open-modal', 'edit-medicine');
        // dd($medicine);
    }

    public function updatedUserId(){
    $this->units = Unit::where('id', $this->userid->id)->get();
    }

    public function updateMedicine(){

        $this->dispatch('close-modal');

        $this->validate([
            'selectedMedicine.name' => 'required|string|max:50',
            'selectedMedicinee.expired' => 'required|date_format:Y-m-d',
        ]);

        Medicine::where('id',$this->selectedMedicine['id'])->update([
            'name' => $this->selectedCategory['name'],
            'expired' => $this->selectedCategory['expired']
        ]);
        $this->reset('selectedMedicine');
        $this->dispatch('notify', ['status' => 'success', 'message' => 'Category Has Been Updated!']);
    }

    public function destroyMedicine() : void
    {
        try{
            DB::transaction(function () {
                // find the desired medicine from database
                $med = Medicine::where('id',$this->selectedMedicine)->with( 'purchases' )->first();

                // get first purchase data to update
                // update the purchase data
                $purchase = $med->purchases->first();
                $purchase->total_purchase = $purchase->total_purchase - $med->purchase_price;
                $purchase->save();

                // detach medicine data from purchase_medicine pivot
                // then delete the medicine from the database
                $med->purchases()->detach();
                $med->delete();
            });
            $this->dispatch('notify', ['message' => 'Medicine has been deleted!', 'status' => 'success']);

        }catch(\Exception $e){
            $this->dispatch('notify', ['message' => 'Error! Medicine cannot be deleted!', 'status' => 'error']);
            throw($e);
        }


        $this->dispatch('close-modal');
        $this->reset('selectedMedicine');
    }
}
