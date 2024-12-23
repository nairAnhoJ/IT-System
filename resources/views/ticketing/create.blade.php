<x-app-layout>
    @section('title')
    HII - Ticketing System
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

    <div style="height: calc(100vh - 65px);" class="py-10 px-80 text-gray-200 w-screen overflow-x-auto">
        <h1 class="mb-3 font-extrabold leading-none text-3xl text-blue-500 tracking-wide">CREATE NEW TICKET</h1>
        <form action="{{ route('ticket.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="nature" class="block text-sm font-medium text-white">Nature of Problem</label>
            <select required id="nature" name="nature" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white">
                @foreach ($cats as $cat)
                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                @endforeach
            </select>

            <div class="mt-5">
                {{-- <input type="hidden" id="ticketInCharge" name="ticketInCharge"> --}}
                <label for="subject" class="block text-sm font-medium text-white">In-Charge</label>
                <h1 id="ticketInChargeDisplay" class="font-semibold">{{ $inchargeName }}</h1>
            </div>

            <div class="mt-5">
                <label for="subject" class="block text-sm font-medium text-white">Subject</label>
                <input required name="subject" id="subject" autocomplete="off" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white">
            </div>

            <div class="mt-5">
                <label for="description" class="block text-sm font-medium text-white">Description</label>
                <textarea required name="description" id="description" autocomplete="off" rows="5" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white"></textarea>
            </div>

            <div class="mt-5">
                <label for="attachment" class="block text-sm font-medium text-white">Upload Attachment</label>
                <div class="grid grid-cols-5 gap-x-5">
                    <div class="col-span-5">
                        <input id="attachment" name="attachment" class="block w-full h-10 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" accept=".png, .jpeg, .jpg">
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <button type="submit" class="w-24 text-white focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-blue-800">Submit</button>
                <a href="{{ route('ticket.index') }}" class="inline-block text-center w-24 text-white focus:outline-none focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 bg-gray-800 hover:bg-gray-700 focus:ring-gray-700 border-gray-700">Back</a>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function(){
            $('#attachment').change(function(){
                var file = $(this).val();
                if(file != ''){
                    $('#viewAttachment').prop("disabled", false);
                }
            });

            $('#nature').change(function(){
                var incharge = $(this).find('option:selected').data('incharge');
                $('#ticketInChargeDisplay').html(incharge);
                $('#ticketInCharge').html(incharge);
            });
        });
    </script>
</x-app-layout>
