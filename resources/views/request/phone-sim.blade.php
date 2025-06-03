<x-app-layout>
    @section('title')
    Phone SIM Request
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

    
    {{-- Complete Modal --}}
    <div id="completeModal" tabindex="-1" class="fixed top-0 left-0 z-50 flex items-center justify-center hidden w-screen h-screen p-4 overflow-hidden bg-gray-900/40">
        <div class="relative w-full h-full max-w-2xl md:h-auto">
            <!-- Modal content -->
            <form action="{{ route('reqPhoneSim.done') }}" method="POST" enctype="multipart/form-data" class="relative rounded-lg shadow bg-gray-700">
                @csrf
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t border-gray-600">
                    <h3 class="text-xl font-semibold text-emerald-500">
                        MARK AS DONE
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center hover:bg-gray-600 hover:text-white closeCompleteModal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                    </button>
                </div>
                <!-- Modal body -->
                <div class="px-6 py-4">
                    <input type="hidden" id="doneId" name="doneId" value="">
                    
                    <div>
                        <label class="block text-sm font-medium text-white">Item</label>
                        <h1 id="doneItemName" class="font-semibold text-white text-sm leading-4"></h1>
                    </div>
                    <div class="mt-2">
                        <label for="description" class="block text-sm font-medium text-white">Description</label>
                        <input type="text" id="description" name="description" autocomplete="off" required class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 @error('description') border-red-500 @else border-gray-600 @enderror placeholder-gray-400 text-white">
                    </div>
                    <div class="mt-2">
                        <label for="serial_number" class="block text-sm font-medium text-white">Serial / SIM Card Number</label>
                        <input type="text" id="serial_number" name="serial_number" autocomplete="off" required class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 @error('serial_number') border-red-500 @else border-gray-600 @enderror placeholder-gray-400 text-white">
                    </div>
                    <div class="mt-2">
                        <label for="cost" class="block text-sm font-medium text-white">Cost (₱)</label>
                        <input type="text" id="cost" name="cost" autocomplete="off" required class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 @error('description') border-red-500 @else border-gray-600 @enderror placeholder-gray-400 text-white">
                    </div>
                    <div class="mt-2">
                        <label for="color" class="block text-sm font-medium text-white">Color</label>
                        <input type="text" id="color" name="color" autocomplete="off" required class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 @error('description') border-red-500 @else border-gray-600 @enderror placeholder-gray-400 text-white">
                    </div>
                    <div class="mt-2">
                        <label for="remarks" class="block text-sm font-medium text-white">Remarks</label>
                        <input type="text" id="remarks" name="remarks" autocomplete="off" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 @error('remarks') border-red-500 @else border-gray-600 @enderror placeholder-gray-400 text-white">
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t rounded-b border-gray-600">
                    <button type="submit" class="text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm py-2.5 text-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-800 w-20">SAVE</button>
                    <button type="button" class="focus:ring-4 focus:outline-none rounded-lg border text-sm font-medium py-2.5 focus:z-10 bg-gray-700 text-gray-300 border-gray-500 hover:text-white hover:bg-gray-600 focus:ring-gray-600 closeCompleteModal w-20">CLOSE</button>
                </div>
            </form>
        </div>
    </div>

    
    
    <div id="attachmentModal" tabindex="-1" class="fixed top-0 left-0 w-screen h-screen flex items-center justify-center bg-gray-900/60 z-50 hidden">
        <button id="closeAttachment" class="absolute top-7 right-7 w-10 h-10 rounded-full bg-gray-700 text-white flex items-center justify-center hover:bg-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor" class="w-6 h-6">
                <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
            </svg>
        </button>
        <img id="attachment" src="" alt="" class="max-h-[80%] w-auto object-contain">
    </div>

    <div style="height: calc(100vh - 65px);" class="p-3 text-gray-200 w-screen">
        <h1 class="mb-1 font-extrabold leading-none text-3xl text-blue-500 tracking-wide">PHONE SIM REQUEST</h1>

        {{-- CONTROLS --}}
        <div class="my-2">
            <div class="flex items-center w-1/4">
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative w-full h-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    <input type="text" id="tableSearch" autocomplete="off" class="h-full border text-sm rounded-lg block w-full pl-10 p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Search" required>
                </div>
            </div>
        </div>
        
        {{-- TABLE --}}
        <div style="max-height: calc(100% - 126px);" class="overflow-x-auto relative shadow-md rounded-t-lg">
            <table class="min-w-full text-sm text-left text-gray-400">
                <thead class="relative top-0 text-xs uppercase bg-gray-600 text-gray-400 border-x-8 border-gray-600">
                        <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            ITEM
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            SITE
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            REQUESTED BY
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            REQUESTED FOR
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            DATE REQUESTED
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            STATUS
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            ATTACHMENT
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            DATE COMPLETED
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            ACTION
                        </th>
                    </tr>
                </thead>
                <tbody style="max-height: calc(100% - 126px);">
                    @foreach ($requests as $request)
                        <tr class="bg-gray-800 border-gray-700 hover:bg-gray-700 cursor-pointer">
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ $request->item }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ $request->req_site->name }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ $request->req_by->name }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ $request->requested_for }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ date('F j, Y', strtotime($request->date_requested)) }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                <span class="
                                    @php
                                        $status = $request->status;
                                        if($status == 'CANCELLED'){
                                            echo 'text-red-500';
                                        }elseif($status == 'PENDING'){
                                            echo 'text-amber-300';
                                        }elseif($status == 'DONE'){
                                            echo 'text-teal-500';
                                        }
                                    @endphp
                                ">
                                    {{ $request->status }}
                                </span>
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                <button id="viewAttachment" data-path="{{ asset($request->attachment) }}" class="text-blue-500 hover:underline font-semibold">VIEW</button>
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ ($request->done_date) ? date('F j, Y', strtotime($request->done_date)) : '' }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                @if ($status == 'PENDING')
                                    <button id="completeButton" data-id="{{ $request->id }}" data-item="{{$request->item}}" class="font-medium text-emerald-500 hover:underline">MARK AS DONE</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            jQuery(document).on("click", "#viewAttachment", function(){
                const path = $(this).data('path');
                $('#attachment').attr('src', path);
                $('#attachmentModal').removeClass('hidden');
            });

            jQuery(document).on("click", "#closeAttachment", function(){
                $('#attachmentModal').addClass('hidden');
            });
            
            jQuery(document).on("click", "#completeButton", function(){
                const id = $(this).data('id');
                const item = $(this).data('item');
                $('#doneId').val(id)
                $('#doneItemName').html(item)
                $('#completeModal').removeClass('hidden');
            });
            
            jQuery(document).on("click", ".closeCompleteModal", function(){
                $('#completeModal').addClass('hidden');
            });



            // $("#tableSearch").on("keyup", function() {
            //     var value = $(this).val().toLowerCase();
            //         $("#itemReqTableBody tr").filter(function() {
            //         $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            //     });
            // });

            // $('.editButton').click(function(e){
            //     e.stopPropagation();
            // });

            // $('.deleteButton').click(function(e){
            //     var id = $(this).data('id');
            //     var deletePRN = $(this).data('pr_no');
            //     $('#deleteID').val(id);
            //     $('#deletePRN').html(deletePRN);
            //     e.stopPropagation();
            // });

            // $('#itemReqTableBody tr').click(function() {
            //     var id = $(this).find("span").data('id');
            //     $('#reqID').val(id);

            //     var pr_no = $(this).find("span").data('pr_no');
            //     $('#PRNumber').html(pr_no);

            //     var item = $(this).find("span").data('item');
            //     $('#item').html(item);

            //     var desc = $(this).find("span").data('desc');
            //     $('#desc').html(desc);

            //     var remarks = $(this).find("span").data('remarks');
            //     $('#remarks').html(remarks);

            //     var req_by = $(this).find("span").data('req_by');
            //     $('#req_by').html(req_by);

            //     var site = $(this).find("span").data('site');
            //     $('#site').html(site);

            //     var status = $(this).find("span").data('status');
            //     $('#status').html(status);
            //     $('#updateStatus').val(status);

            //     if(status == 'DECLINED'){
            //         $('#status').removeClass('text-amber-300');
            //         $('#status').removeClass('text-teal-500');
            //         $('#status').addClass('text-red-500');
            //         $('#updateButtonDiv').html(``);
            //         $('#updateStatus').prop('disabled', true);
            //         $('#updateStatusLabel').addClass('opacity-50');
            //     }else if(status == 'REQUESTED'){
            //         $('#status').removeClass('text-red-500');
            //         $('#status').removeClass('text-teal-500');
            //         $('#status').addClass('text-amber-300');
            //         $('#updateButtonDiv').html(`<button disabled data-modal-toggle="itemModal" type="submit" id="updateButton" class="disabled:opacity-50 disabled:pointer-events-none text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 mr-3 py-2.5 text-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-800">Update</button>`);
            //         $('#updateStatus').prop('disabled', false);
            //         $('#updateStatusLabel').removeClass('opacity-50');
            //     }else if(status == 'DELIVERED'){
            //         $('#status').removeClass('text-red-500');
            //         $('#status').removeClass('text-amber-300');
            //         $('#status').addClass('text-teal-500');
            //         $('#updateButtonDiv').html(``);
            //         $('#updateStatus').prop('disabled', true);
            //         $('#updateStatusLabel').addClass('opacity-50');
            //     }

            //     var date_requested = $(this).find("span").data('date_req');
            //     $('#date_requested').html(date_requested);

            //     var date_delivered = $(this).find("span").data('date_del');
            //     $('#date_delivered').html(date_delivered);

            //     $('#viewReq').click();
            // });

            // jQuery(document).on("change", "#updateStatus", function(){
            //     var status = $(this).val();
            //     if(status == 'DECLINED'){
            //         $('#updateButton').prop('disabled', false);
            //     }else if(status == 'REQUESTED'){
            //         $('#updateButton').prop('disabled', true);
            //     }else if(status == 'DELIVERED'){
            //         $('#updateButton').prop('disabled', false);
            //     }
            // });
        });
    </script>
</x-app-layout>
