<div>
    <x-slot name="header">
        Edit Purchase
    </x-slot>

    <div class="flex flex-col pt-4 px-4 rounded-lg md:flex-row items-center dark:bg-gray-800 justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
        <div class="w-full md:w-1/2">
            <form class="flex items-center">
                <label for="simple-search" class="sr-only">Search</label>
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
                    {{-- @foreach ($medicines as $medicine) --}}
                        <tr wire:key="" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <td class="px-6 py-4"> </td>
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4">
                                <a href="" type="button" class="block font-medium text-green-600 dark:text-green-400 hover:underline">Details</button>
                                <a href="" wire:navigate class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                <button class="block font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                            </td>
                        </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
            <nav class="flex flex-col items-start justify-between p-4 bg-white dark:bg-gray-700  space-y-3 md:flex-row md:items-center md:space-y-0" aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-200">
                    Menampilkan
                    <span class="font-semibold text-gray-900 dark:text-gray-50"></span>
                    dari
                    <span class="font-semibold text-gray-900 dark:text-gray-50"></span>
                </span>
                <button type="button" wire:click="loadMore()" class="text-sm font-normal text-indigo-600 dark:text-indigo-400">
                    Muat Lebih ...
                </button>
            </nav>
        </div>
    </div>
</div>
