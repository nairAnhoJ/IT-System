<x-app-layout>
    @section('title')
    Return Items
    @endsection
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
    </style>

    <div style="height: calc(100vh - 65px);" class="p-3 text-gray-200 w-screen">
        <div class="grid grid-cols-2 mb-2">
            <div class="flex items-center">
                <h1 class="font-extrabold leading-none text-3xl text-blue-500 tracking-wide">RETURN ITEMS</h1>
            </div>
            {{-- <div class="justify-self-end">
                <a href="{{ route('defectiveIndex.index') }}" class="h-full text-white font-medium rounded-lg text-sm px-10 py-2 mr-2 bg-blue-600 hover:bg-blue-700 focus:outline-none">Return Item/s</a>
                <a href="{{ route('defectiveIndex.index') }}" class="h-full text-white font-medium rounded-lg text-sm px-10 py-2 bg-blue-600 hover:bg-blue-700 focus:outline-none">Defective Items</a>
            </div> --}}
        </div>
        <div class="mt-10">
            <div class="grid grid-cols-8 gap-x-10 content-center">
                <div class="flex items-center">
                    <span>Name:</span>
                </div>
                <div class="col-span-3">
                    <div>
                        <input type="text" id="small-input" class="block w-full p-2 border rounded-lg sm:text-xs bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="flex items-center">
                    <span>Department:</span>
                </div>
                <div class="col-span-3">
                    <div>
                        <input type="text" id="small-input" class="block w-full p-2 border rounded-lg sm:text-xs bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="flex items-center mt-4">
                    <span>Location:</span>
                </div>
                <div class="col-span-3 mt-4">
                    <div>
                        <select id="site" name="site" autocomplete="off" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white">
                            @foreach ($sites as $site)
                                <option value="{{ $site->id }}">{{ $site->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="w-1/2 flex justify-between items-center mt-7">
                <h1 class="font-bold text-2xl tracking-wider text-gray-200">ITEMS</h1>
                <button><i class="uil uil-plus-circle text-blue-500 text-4xl"></i><span class="leading-9">Add Item</span></button>
            </div>

            <div>
                <div class="mt-3">
                    <label for="countries" class="block text-sm font-medium text-white">ITEM 1</label>
                    <select id="site" name="site" autocomplete="off" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white">
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}">{{ $item->brand }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>



    </div>

    <script>
        $(document).ready(function(){

        });
    </script>
</x-app-layout>
