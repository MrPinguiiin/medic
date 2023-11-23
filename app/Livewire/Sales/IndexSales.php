<?php

namespace App\Livewire\Sales;

use App\Models\Medicine;
use App\Models\Sell;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class IndexSales extends Component
{
    use WithPagination;
    public $selectedSales;
    public $total_sell;
    public int $perPage = 10;
    public $search_sellerName = '';

    public $search = '';


    public function render() : View
    {
        // $sales = Sell::latest()->get();
        $sales = Sell::where('invoice', 'like', '%'.$this->search.'%')
        ->orWhere('seller_name', 'like', '%'.$this->search. '%')
        ->latest()->paginate($this->perPage);

        return view('livewire.sales.index-sales', ['sales' => $sales]);

    }



}
