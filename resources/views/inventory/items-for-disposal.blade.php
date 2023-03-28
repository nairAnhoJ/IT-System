<x-app-layout>
    @section('title')
    Items For Disposal
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

    <div class="p-3 text-gray-200 w-screen">
        <div class="grid grid-cols-2 mb-2">
            <div class="flex items-center">
                <h1 class="font-extrabold leading-none text-3xl text-blue-500 tracking-wide">ITEMS FOR DISPOSAL</h1>
            </div>
            <div class="justify-self-end">
                <a href="{{ route('defectiveIndex.index') }}" class="h-full text-white font-medium rounded-lg text-sm px-10 py-2 bg-blue-600 hover:bg-blue-700 focus:outline-none">Disposed Items</a>
            </div>
        </div>
        <div>
            
        </div>
    </div>

    <script>
        $(document).ready(function(){
            
        });
    </script>
</x-app-layout>
