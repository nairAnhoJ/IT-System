<x-app-layout>
    @section('title')
    Item Request
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

    <div style="height: calc(100vh - 65px);" class="py-10 px-80 text-gray-200 w-screen overflow-x-auto">
        <h1 class="mb-3 font-extrabold leading-none text-3xl text-blue-500 tracking-wide">ITEM REQUEST</h1>
        <form action="{{ route('request.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label for="type" class="mt-5 block text-sm font-medium text-white">Item</label>
            <select required id="type" name="type" autocomplete="off" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white">
                <option value="PHONE">PHONE</option>
                <option value="SIM">SIM</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>

            <div class="mt-5">
                <label for="requested_for" class="block text-sm font-medium text-white">Requested For</label>
                <input type="text" id="requested_for" name="requested_for" autocomplete="off" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 @error('requested_for') border-red-500 @else border-gray-600 @enderror placeholder-gray-400 text-white">
            </div>

            <label for="site" class="mt-5 block text-sm font-medium text-white">Branch / Site</label>
            <select required id="site" name="site" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white">
                @foreach ($sites as $site)
                    <option value="{{ $site->id }}">{{ $site->name }}</option>
                @endforeach
            </select>

            <div class="mt-5">
                <label for="attachment" class="block text-sm font-medium text-white">Attachment</label>
                <input type="file" id="attachment" name="attachment" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full bg-gray-700  @error('attachment') border-red-500 @else border-gray-600 @enderror placeholder-gray-400 text-white" accept="image/png, image/jpeg">
            </div>

            <div class="mt-5">
                <button type="submit" class="w-24 text-white focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-blue-800">Submit</button>
                <a href="{{ route('request.index') }}" class="inline-block text-center w-24 text-white focus:outline-none focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 bg-gray-800 hover:bg-gray-700 focus:ring-gray-700 border-gray-700">Back</a>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function(){

        });
    </script>
</x-app-layout>
