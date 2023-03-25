<x-app-layout>
    @section('title')
    Ticket - Add
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
        <form action="{{ route('ticket.storeForIT') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="nature" class="block text-sm font-medium text-white">Nature of Problem</label>
            <select required id="nature" name="nature" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white">
                @foreach ($cats as $cat)
                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                @endforeach
            </select>


            <div>
                <label for="brand" class="mt-3 block text-sm font-medium text-white">User</label>
                <div class="wrapper w-full relative">
                    <div class="select-btn flex items-center justify-between rounded-md bg-gray-700 p-2 h-9 cursor-pointer">
                        <span>{{ $users[0]->name }}</span>
                        <i class="uil uil-angle-down text-2xl transition-transform duration-300"></i>
                    </div>
                    <div class="content bg-gray-700 mt-1 rounded-md p-3 hidden absolute w-full z-50 border border-gray-500">
                        <div class="search relative">
                            <i class="uil uil-search absolute left-3 leading-9 text-gray-500"></i>
                            <input type="text" class="selectSearch w-full leading-9 text-gray-700 rounded-md pl-9 outline-none h-9" placeholder="Search">
                        </div>
                        <ul class="listOption options mt-2 max-h-64 overflow-y-auto">
                            @foreach ($users as $user)
                                <li data-id="{{ $user->id }}" data-name="{{ $user->name }}" class="h-9 cursor-pointer hover:bg-gray-800 rounded-md flex items-center pl-3 leading-9">{{ $user->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <input type="hidden" name="user" value="{{ $users[0]->id }}">
                </div>
            </div>

            {{-- <div class="mt-5">
                <label for="user" class="block text-sm font-medium text-white">User</label>
                <select required id="user" name="user" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white">
                    @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
            </div> --}}

            <div class="mt-5">
                <label for="subject" class="block text-sm font-medium text-white">Subject</label>
                <input required name="subject" id="subject" autocomplete="off" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white">
            </div>

            <div class="mt-5">
                <label for="description" class="block text-sm font-medium text-white">Description</label>
                <textarea required name="description" id="description" autocomplete="off" rows="3" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white"></textarea>
            </div>

            <div class="mt-5">
                <label for="description" class="block text-sm font-medium text-white">Status</label>
                <div class="flex">
                    <div class="flex items-center">
                        <input checked type="radio" value="PENDING" name="status" class="statusRadio w-4 h-4 text-blue-600 focus:ring-blue-600 ring-offset-gray-800 focus:ring-2 bg-gray-700 border-gray-600">
                        <label for="statusPending" class="ml-1 text-sm font-medium text-red-500">PENDING</label>
                    </div>
                    <div class="flex items-center ml-4">
                        <input type="radio" value="ONGOING" name="status" class="statusRadio w-4 h-4 text-blue-600 focus:ring-blue-600 ring-offset-gray-800 focus:ring-2 bg-gray-700 border-gray-600">
                        <label for="statusOngoing" class="ml-1 text-sm font-medium text-amber-300">ONGOING</label>
                    </div>
                    <div class="flex items-center ml-4">
                        <input type="radio" value="DONE" name="status" class="statusRadio w-4 h-4 text-blue-600 focus:ring-blue-600 ring-offset-gray-800 focus:ring-2 bg-gray-700 border-gray-600">
                        <label for="statusDone" class="ml-1 text-sm font-medium text-teal-500">DONE</label>
                    </div>
                </div>
            </div>

            <div id="ResolutionDiv" class="hidden mt-5">
                <label for="resolution" class="block text-sm font-medium text-white">Resolution</label>
                <textarea name="resolution" id="resolution" autocomplete="off" rows="3" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white"></textarea>
            </div>

            <div class="mt-5">
                <label for="attachment" class="block text-sm font-medium text-white">Upload Attachment</label>
                <div class="grid grid-cols-5 gap-x-5">
                    <div class="col-span-5">
                        <input id="attachment" name="attachment" class="block w-full h-10 text-sm border rounded-lg cursor-pointer text-gray-400 focus:outline-none bg-gray-700 border-gray-600 placeholder-gray-400" type="file" accept="image/*">
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

            $('.statusRadio').click(function(){
                var status = $(this).val();

                if(status == 'DONE'){
                    $('#ResolutionDiv').removeClass('hidden');
                    $('#resolution').prop('required', true)
                }else{
                    $('#ResolutionDiv').addClass('hidden');
                    $('#resolution').prop('required', false)
                }
            });







            $('.select-btn').click(function(e){
                $('.content').not($(this).closest('.wrapper').find('.content')).addClass('hidden');
                $(this).closest('.wrapper').find('.content').toggleClass('hidden');
                $(this).closest('.wrapper').find('.uil-angle-down').toggleClass('-rotate-180');
                e.stopPropagation();
            });

            function searchFilter(searchInput){
                $(".listOption li").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchInput) > -1)
                });
            }

            $('.content').click(function(e){
                e.stopPropagation();
            });
            
            $(".selectSearch").on("input", function() {
                var value = $(this).val().toLowerCase();
                searchFilter(value);
            });

            $(".listOption li").click(function(){
                var id = $(this).data('id');
                var name = $(this).data('name');
                $(this).closest('.wrapper').find('input').val(id);
                $(this).closest('.wrapper').find('.select-btn span').html(name);
                $('.content').addClass('hidden');
                $('.selectSearch').val('');
                var value = $(".selectSearch").val().toLowerCase();
                searchFilter(value);
            });

            $(document).click(function() {
                $('.content').addClass('hidden');
                $('.uil-angle-down').removeClass('-rotate-180');
            });
        });
    </script>
</x-app-layout>
