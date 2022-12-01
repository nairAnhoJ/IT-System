<x-app-layout>
    <div style="height: calc(100vh - 65px);" class="p-3 text-gray-200 w-screen">
        <h1 class="mb-2 font-extrabold leading-none text-3xl text-blue-500 tracking-wide">ITEMS</h1>
        <div class="grid grid-cols-2 mb-2 h-10">
            <div class="h-10">
                <button type="button" class="h-full text-white focus:ring-4 font-medium rounded-lg text-sm px-10 py-2.5 mr-2 mb-2 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-blue-800">Add Item</button>
            </div>
            <div class="flex gap-x-3 h-10">
                <div class="w-1/3">
                    <select id="countries" class="border text-sm rounded-lg block p-2.5 w-full h-full bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500">
                        <option selected value="all">All Item Type</option>
                        <option value="proc">Processor</option>
                        <option value="mobo">Motherboard</option>
                        <option value="ram">RAM</option>
                        <option value="hhd">HDD</option>
                        <option value="ssd">SSD</option>
                    </select>
                </div>
                <div class="flex items-center w-2/3">
                    <label for="simple-search" class="sr-only">Search</label>
                    <div class="relative w-full h-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="text" id="simple-search" class="h-full border text-sm rounded-lg block w-full pl-10 p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Search" required>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-400">
                <thead class="text-xs uppercase bg-gray-600 text-gray-400 border-x-8 border-gray-600">
                    <tr>
                        <th scope="col" class="py-3 px-6 text-center">
                            #
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            TYPE
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            ITEM CODE
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            BRAND
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            DESCRIPTION
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            SERIAL NUMBER
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            DATE PURCHASED
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            STATUS
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            COMPUTER NAME
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            SITE
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            ACTION
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-gray-800 border-gray-700 hover:bg-gray-700">
                        <th scope="row" class="py-4 px-6 font-medium whitespace-nowrap text-white text-center">
                            1
                        </th>
                        <td class="py-4 px-6 text-center">
                            PROCESSOR
                        </td>
                        <td class="py-4 px-6 text-center">
                            HII-000148
                        </td>
                        <td class="py-4 px-6 text-center">
                            INTEL
                        </td>
                        <td class="py-4 px-6 text-center">
                            CORE I5 11400F
                        </td>
                        <td class="py-4 px-6 text-center">
                            BFEBFBFF000A0671
                        </td>
                        <td class="py-4 px-6 text-center">
                            7/1/2022
                        </td>
                        <td class="py-4 px-6 text-center">
                            IN USE
                        </td>
                        <td class="py-4 px-6 text-center">
                            HII_PC-999
                        </td>
                        <td class="py-4 px-6 text-center">
                            BATAAN
                        </td>
                        <td class="py-4 px-6 text-center">
                            <a href="#" class="font-medium text-blue-500 hover:underline">Edit</a> | 
                            <a href="#" class="font-medium text-red-500 hover:underline">Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
