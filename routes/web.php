<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Category\IndexCategory;
use App\Livewire\Dashboard;
use App\Livewire\EditMedicine as LivewireEditMedicine;
use App\Livewire\Medicine\DetailMedicine;
use App\Livewire\Medicine\IndexMedicine;
use App\Livewire\Medicine\AddMedicine;
use App\Livewire\Purchase\AddPurchase;
use App\Livewire\Purchase\IndexPurchase;
use App\Livewire\Sales\IndexSales;
use App\Livewire\Supplier\IndexSupplier;
use App\Livewire\Medicine\EditMedicine;
use App\Livewire\Purchase\EditPurchase;
use App\Livewire\Sales\AddSales;
use App\Livewire\Unit\IndexUnit;
use App\Livewire\User\UserProfile;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/medicines', IndexMedicine::class)->name('medicines.index');
    Route::get('/medicines/create', AddMedicine::class)->name('medicines.create');
    Route::get('/medicines/edit-medicines/{medicine}', EditMedicine::class)->name('medicines.edit');
    Route::get('/medicines/detail-medicines/{medicine}', DetailMedicine::class)->name('medicines.detail');


    Route::get('/categories', IndexCategory::class)->name('categories.index');

    Route::get('/units', IndexUnit::class)->name('units.index');
    Route::get('/suppliers', IndexSupplier::class)->name('suppliers.index');


    Route::get('/sales', IndexSales::class)->name('sales.index');
    Route::get('/sales/create', AddSales::class)->name('sales.create');


    Route::get('/purchases', IndexPurchase::class)->name('purchases.index');
    Route::get('/purchases/create', AddPurchase::class)->name('purchases.create');
    Route::get('/purchases/edit', EditPurchase::class)->name('purchases.edit');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', UserProfile::class)->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
