<x-app-layout>

    <style>
        /* width */
        ::-webkit-scrollbar {
          width: 10px;
          height: 10px;
        }
        
        /* Track */
        ::-webkit-scrollbar-track {
          box-shadow: inset 0 0 2px grey; 
          border-radius: 10px;
        }
         
        /* Handle */
        ::-webkit-scrollbar-thumb {
          background: #4B5563; 
          border-radius: 10px;
        }
        
        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
          background: rgb(95, 95, 110); 
        }
    /* ::-webkit-scrollbar {
        width: 0px;
        background: transparent;
    } */

    #thl::before{
        content: '';
        position: absolute;
        top: 0;
        left: -8px;
        width: 8px;
        height: 32px;
        background-color: rgb(75 85 99 / var(--tw-bg-opacity));
    }

    #thr::before{
        content: '';
        position: absolute;
        top: 0;
        right: -8px;
        width: 8px;
        height: 32px;
        background-color: rgb(75 85 99 / var(--tw-bg-opacity));
    }

    </style>

    <div style="height: calc(100vh - 65px);" class="p-3 text-gray-200 w-screen">
        <h1 class="mb-1 font-extrabold leading-none text-3xl text-blue-500 tracking-wide">ITEMS</h1>

        {{-- CONTROLS --}}
        <div class="grid grid-cols-2 mb-0 h-10">
            <div class="h-8">
                <a href="{{ route('item.add') }}" type="button" class="h-full text-white focus:ring-4 font-medium rounded-lg text-sm px-10 pt-2 mr-2 mb-2 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-blue-800">Add Item</a>
            </div>
            <div class="flex gap-x-3 h-8">
                <div class="w-1/3">
                    <select id="countries" class="border text-sm rounded-lg block px-2.5 pt-1 pb-0 w-full h-full bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500">
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
                        <input type="text" id="tableSearch" class="h-full border text-sm rounded-lg block w-full pl-10 p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Search" required>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- TABLE --}}
        <div style="max-height: calc(100% - 126px);" class="overflow-x-auto relative shadow-md rounded-t-lg">
            <table class="min-w-full text-sm text-left text-gray-400">
                <thead class="relative top-0 text-xs uppercase bg-gray-600 text-gray-400 border-x-8 border-gray-600">
                    <tr class="bg-gray-600 sticky top-0">
                        <th id="thl" scope="col" class="sticky top-0 py-2 text-center">
                            #
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center">
                            TYPE
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            ITEM CODE
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center">
                            BRAND
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center">
                            DESCRIPTION
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            SERIAL NUMBER
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            DATE PURCHASED
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center">
                            STATUS
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            COMPUTER NAME
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center">
                            SITE
                        </th>
                        <th id="thr" scope="col" class="sticky top-0 py-2 text-center">
                            ACTION
                        </th>
                    </tr>
                </thead>
                <tbody id="itemTableBody" style="max-height: calc(100% - 126px);">
                    <tr class="bg-gray-800 border-gray-700 hover:bg-gray-700">
                        <th scope="row" class="py-3 px-6 font-medium text-white text-center">
                            1
                        </th>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            PROCESSOR
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            HII-000148
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            INTEL
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            CORE I5 11400F
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            BFEBFBFF000A0671
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            7/1/2022
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            IN USE
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            HII_PC-999
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            BATAAN
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            <a href="#" class="font-medium text-blue-500 hover:underline">Edit</a> | 
                            <a href="#" class="font-medium text-red-500 hover:underline">Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $("#tableSearch").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                    $("#itemTableBody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</x-app-layout>
