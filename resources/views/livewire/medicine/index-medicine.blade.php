<div>
    <x-slot name="header">
        Medicines
    </x-slot>

    <div class="flex flex-col pt-4 px-4 rounded-lg md:flex-row items-center dark:bg-gray-800 justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
        <div class="w-full md:w-1/2">
            <form class="flex items-center">
                <span for="simple-search" class="sr-only">Search</span>
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" wire:model.live.debounce.500ms="search" id="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" placeholder="Search" required="">
                </div>
            </form>
        </div>
        <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
            {{-- <a href="{{ route('medicines.create')}}" wire:navigate class="flex items-center justify-center text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                <svg  class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                </svg>
                Add Medicine
            </a> --}}
            <select wire:model.live.debounce.500ms="filter_unit" class="py-2 dark:bg-gray-700 dark:text-white rounded-full">
                <option value=""> Filter Unit </option>
                @foreach ($units as $unit)
                <option value="{{ $unit->id }}"> {{ $unit->name }} </option>
                @endforeach
            </select>
            <select wire:model.live.debounce.500ms="filter_category" class="py-2 dark:bg-gray-700 dark:text-white rounded-full">
                <option value=""> Filter Category </option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}"> {{ $category->name }} </option>
                @endforeach
            </select>
            <select wire:model.live.debounce.500ms="filter_expired" class="py-2 dark:bg-gray-700 dark:text-white rounded-full">
                <option value=""> Filter Expired </option>
                <option value="1"> Expired </option>
                <option value="0"> Not Expired </option>
            </select>
        </div>
    </div>
    <div class="mt-2 relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="min-h-[75vh] max-h-[80vh]">
            <table class=" w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Id</th>
                        <th scope="col" class="px-6 py-3"> Name</th>
                        <th scope="col" class="px-6 py-3"> Stock</th>
                        <th scope="col" class="px-6 py-3"> Unit</th>
                        <th scope="col" class="px-6 py-3"> Category</th>
                        <th scope="col" class="px-6 py-3"> Expired</th>
                        <th scope="col" class="px-6 py-3"> Purchase Price</th>
                        <th scope="col" class="px-6 py-3"> Selling Price</th>
                        <th scope="col" class="px-6 py-3"> Supplier</th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($medicines as $medicine)
                        <tr wire:key="{{ $medicine->id }}" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $medicine->id }}</td>
                            <td class="px-6 py-4" >{{ $medicine->name }}</td>
                            <td class="px-6 py-4">{{ $medicine->stock }}</td>
                            <td class="px-6 py-4">{{ $medicine->unit->name}}</td>
                            <td class="px-6 py-4">{{ $medicine->category->name}}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $medicine->expired)->format('d M Y') }}</td>
                            <td class="px-6 py-4">Rp {{number_format($medicine->purchase_price, 0, ',','.')}}</td>
                            <td class="px-6 py-4">Rp {{number_format($medicine->selling_price, 0, ',','.')}}</td>
                            <td class="px-6 py-4">{{ $medicine->supplier->name}}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('medicines.detail', $medicine) }}" type="button" class="block font-medium text-green-600 dark:text-green-400 hover:underline">Details</a>
                                <a href="{{ route('medicines.edit', $medicine) }}" type="button" class="block font-medium text-blue-600 dark:text-blue-400 hover:underline">Edit</a>
                                    {{-- <button x-on:click="$dispatch('open-modal', 'edit-medicine')" wire:click="editMedicine( {{ $medicine }})" class="block font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                     Edit
                                    </button> --}}
                                <button wire:click="deleteMedicine({{ $medicine }})" class="block font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <nav class="flex flex-col items-start justify-between p-4 bg-white dark:bg-gray-700  space-y-3 md:flex-row md:items-center md:space-y-0" aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-200">
                    Menampilkan
                    <span class="font-semibold text-gray-900 dark:text-gray-50">{{ $medicines?->count() }}</span>
                    dari
                    <span class="font-semibold text-gray-900 dark:text-gray-50">{{ $medicines?->total() }}</span>
                </span>
                <button type="button" wire:click="loadMore()" class="text-sm font-normal text-indigo-600 dark:text-indigo-400">
                    Muat Lebih ...
                </button>
            </nav>
        </div>
    </div>
    <x-modal name="delete-medicine" focusable>
        <form id="destroy-medicine" @submit.prevent="show = false">
            <div class="p-6 dark:bg-gray-900">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-200">
                    Are you sure you want to delete <span class="font-bold underline"> {{ $selectedMedicine ? $selectedMedicine['name'] : 'this' }} </span> medicine?
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    This category may have data related to it, once the category deleted, all the data that related to it will be impacted.
                </p>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="ml-3" type="submit" wire:click="destroyMedicine" wire:submit.attr="disabled" wire:target="destroyMedicine">
                        {{ __('Delete Medicine') }}
                    </x-danger-button>
                </div>
            </div>
        </form>
    </x-modal>


    <x-modal x-data name="edit-medicine" focusable>
        <div class="bg-gray-50 dark:bg-gray-900 shadow-md rounded-lg py-2 px-4 h-fit">
            <div class="flex bg-gray-400 text-gray-50 dark:bg-gray-700 dark:text-gray-400 py-4 rounded-xl item-center justify-center">
                Edit Medicine
            </div>
            <form class="p-4" wire:submit="editMedicine" @submit.prevent="show = false">
                <div class="relative z-0 w-full mb-6 group p-2">
                    <input type="text" name="name" wire:model="selectedMedicine.name" id="name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        Name Medicine <span class="text-xs font-light text-red-500">*</span>
                    </label>
                    @error('selectedMedicine.name')
                    <x-input-error :messages="$message" class="mt-2" />
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-6 group p-2">
                    <select wire:model="selectedMedicine.unit" required id="selectedMedicine.unit" class="flex w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="">Select Unit</option>
                        @forelse ($units as $unit)
                        <option value="{{$unit->id}}" selectedp>{{ $unit->name }} </option>
                        @empty
                        No data!
                        @endforelse
                    </select>
                    <label for="name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                       Unit <span class="text-xs font-light text-red-500">*</span>
                    </label>
                    @error('selectedMedicine.unit')
                    <x-input-error :messages="$message" class="mt-2" />
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-6 group p-2">
                    <select wire:model="selectedMedicine.category" required id="selectedMedicine.category" class="flex w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option selected="" disabled>Select Category</option>
                        @forelse ($categories as $category)
                        <option value="{{$category->id}}">{{ $category->name }} </option>
                        @empty
                        No data!
                        @endforelse
                    </select>
                    <label for="name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                       Category <span class="text-xs font-light text-red-500">*</span>
                    </label>
                    @error('selectedMedicine.category')
                    <x-input-error :messages="$message" class="mt-2" />
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-6 group p-2">
                    {{-- <input type="date" name="expired" id="description" value="{{ $ex != null ? \Carbon\Carbon::createFromFormat('Y-m-d', $ex)->format('mm/dd/yyyy') }} : '' "  wire:model="selectedMedicine.expired" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required /> --}}
                    <input type="date" name="expired" id="description" value="{{ $ex != null ? $ex : '' }}"  wire:model="selectedMedicine.expired" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Expired</label>
                    @error('selectedMedicine.expired')
                    <x-input-error :messages="$message" class="mt-2" />
                    @enderror
                </div>
                <div class="flex justify-end">
                    <x-secondary-button class="mx-4 px-5 py-2.5 capitalize" x-on:click="$dispatch('close-modal')">
                        Cancel
                    </x-secondary-button>
                    <button type="submit" wire:submit.attr="disabled" wire:target="updateMedicine" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
