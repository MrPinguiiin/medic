<?php

namespace App\Livewire\Sales;

use App\Models\Category;
use App\Models\Medicine;
use App\Models\Sell;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use App\Models\Unit;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation;
use Throwable;

class AddSales extends Component
{

    // Column model for new Sales data
    public $invoise;
    public $seller_name;
    public $purchase_date;
    public $sell_date;
    public $total_sales;
    public $selectedMedicine;

    public $total_quantity;
    public $total_medicine;
    public $invoice;

    // Data for select input for new Medicine data
    public $categories;
    public $units;
    public $sales;

    // Column model for new Medicine data
    public $name;
    public $stock;
    public $storage;
    public $expired;
    public $description;
    public $purchase_price;
    public $selling_price;

    // column model for new medicine data that set from select input
    public $unit_id = '';
    public $category_id = '';
    public $sales_id = '';

    // Column model for createing new unit data
    public $unitName;

    // Column model for creating new category data
    public $categoryName;
    public $categoryDescription;

    // Column model for creating new supplier data
    public $supplierName;
    public $supplierAddress;
    public $supplierPhone;

    // Sales data variable
    // For now the data is array
    public $newSales;
    public $medicines;
    public $validateSales;
    public $newMedicines;

    // Medicine data variable
    // For now the data is array

    public function render() : View
    {

        $this->sales = Sell::latest()->get();
        $this->categories = Category::latest()->get();
        $this->units = Unit::latest()->get();
        $this->medicines = Medicine::latest()->get();


        return view('livewire.sales.add-sales', ['medicine, sales']);
    }

    //Funtion Go To Medicine Form
    public function appendNewSales() : void {

        $this->validate([
            'sell_date' => 'required|date_format:Y-m-d',
            'seller_name'=> 'required|string|max:250',
        ]);

        $this->newSales = [

            'sell_date' => $this->sell_date,
            'seller_name'=> $this->seller_name,
        ];
        $this->dispatch('set-sales-tab','medicine_form');
        // dd($this->newSales);
    }

    // Function Go To Summary
    public function appendNewMedicine() : void
    {
        $this->validateMedicine();
        $this->newMedicines[] = [
            'name' => $this->name,
            'stock' => $this->stock,
            'selling_price' => $this->selling_price,
            'expired' => $this->expired,
            'storage' => $this->storage,
        ];
        $this->clearNewSalesForm();
        $this->dispatch('notify', ['message' => 'Medicine Has Been Added!', 'status' =>'success']);
        $this->getSummaryData();
        // dd($this->newMedicines);
    }

    private function validateMedicine() : void
    {
        $this->validate([
            'name' => 'required|string|max:250',
            'stock' => 'required|integer|min:1|max:9999|min_digits:1|max_digits:4',
            'selling_price' => 'required|integer|min_digits:2|max_digits:8',
            'expired' => 'required|date_format:Y-m-d',
            'storage' => 'nullable|string|max:250',
        ]);
    }

         //Clear Form New Sales
        public function clearNewSalesForm() : void {

            $this->reset(
                'name',
                'stock',
                'selling_price',
                'expired',
                'storage',
            );
        }

     // Unset Medicine
     public function unsetASales( array $sales ) : void
     {
         // unset an item of medicine from $this->newMedicines
         // return void
         if( ($key = array_search($sales, $this->newSales) ) !== false ) {
             unset($this->newSales[$key]);
         }
         $this->getSummaryData();        # Dont use this function,
     }


    //Validation Medicine

    //Get Summary Data
    public function getSummaryData() : void {

        if($this->newSales == null){
            $this->reset('total_sales', 'total_medicine', 'total_quantity', 'invoice');
            return ;
        }
        $new_total_sales = 0;
        $new_total_sales = 0;
        $new_total_quantity = 0;
        $total_medicine = 0;
        // foreach($this->newSales as $key => $sell){
        //     $new_total_sales +=  $sell['selling_price'] * $sell['quantity'];
            // $new_total_quantity += $med['stock'];
        // }
        $this->total_sales = $new_total_sales;
        $this->total_quantity = $new_total_quantity;
        $this->total_medicine = count($this->newSales);
        $this->invoice = $this->invoice == null ? Str::random(7) : $this->invoice;
    }


    //Validate Sales

    public function validateSales() : void
    {
        $this->validate([
            'sell_date' => 'required|date_format:Y-m-d',
            'seller_name' => 'required|string|max:250',
            'invoice' => 'required|string|unique:purchases,invoice',
            'total_sales' => 'required|integer|min_digits:2|max_digits:8',
        ]);
    }
    public function saveMedicineSales()
    {
        // save purchase and all medicine data to database
        // then attach each medicine to purchase relation
        // then return redirect to purchases.index route
        $this->validateSales();
        try{
            DB::transaction(function() {
                $sales_created = $this->saveSales();
                foreach( $this->newsales as $key => $newSales) {
                    $sales_created = $this->saveSales( $newSales );
                    $sales_created->medicines()->attach($sales_created->id,
                    ['quantity' => $sales_created->stock, 'selling_price' => $sales_created->selling_price]);
                }
            });
        }catch( \Exception $e ) {
            throw($e);
        }
        session()->flash( 'success-notify', 'Purchase Has Been Created!' );
        $this->redirect(
            route('purchases.index'),
            navigate: true
        );
    }

    private function saveSales() : Sell|Throwable
    {
        // save purchase data to database
        // then return back the instance
        try{
            $new_sales = Sell::create([
                'invoice' => $this->invoice,
                'seller_name' => $this->seller_name,
                'selling_date' => $this->selling_date,
                'total_sell' => $this->total_sell,
            ]);
            return $new_sales;
        }catch( \Exception $e ){
            throw($e);
        }
    }

    private function saveMedicine( array $med ) : Medicine|Throwable
    {
         // save medicine data to database
        // then return back the instance
        try{
            $new_medicine = Medicine::create([
                'name' => $med['name'],
                'stock' => (int) $med['stock'],
                'storage' => $med['storage'],
                'expired' => $med['expired'],
                'selling_price' => $med['selling_price'],
            ]);
            return $new_medicine;
        }catch(\Exception $e){
            throw($e);
        }
    }

    public function regenerateInvoiceCode() : void
    {
        $this->invoice = Str::random(7);
    }

}

