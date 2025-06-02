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


    <!-- Main modal -->
    <div id="completeModal" tabindex="-1" class="fixed top-0 left-0 z-50 flex items-center justify-center hidden w-screen h-screen p-4 overflow-hidden bg-gray-900/40">
        <div class="relative w-full h-full max-w-2xl md:h-auto">
            <!-- Modal content -->
            <form action="{{ route('reqItem.done') }}" method="POST" enctype="multipart/form-data" class="relative rounded-lg shadow bg-gray-700">
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
                    {{-- <div class="mt-2">
                        <label for="pr_no" class="block text-sm font-medium text-white">PR Number</label>
                        <input type="text" id="pr_no" name="pr_no" autocomplete="off" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 @error('pr_no') border-red-500 @else border-gray-600 @enderror placeholder-gray-400 text-white">
                    </div> --}}
                    <div class="mt-2">
                        <label for="brand" class="block text-sm font-medium text-white">Brand</label>
                        <input type="text" id="brand" name="brand" autocomplete="off" required class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 @error('brand') border-red-500 @else border-gray-600 @enderror placeholder-gray-400 text-white">
                    </div>
                    <div class="mt-2">
                        <label for="description" class="block text-sm font-medium text-white">Description</label>
                        <input type="text" id="description" name="description" autocomplete="off" required class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 @error('description') border-red-500 @else border-gray-600 @enderror placeholder-gray-400 text-white">
                    </div>
                    <div class="mt-2">
                        <label for="serial_number" class="block text-sm font-medium text-white">Serial Number</label>
                        <input type="text" id="serial_number" name="serial_number" autocomplete="off" required class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 @error('serial_number') border-red-500 @else border-gray-600 @enderror placeholder-gray-400 text-white">
                    </div>
                    <div class="mt-2">
                        <label for="remarks" class="block text-sm font-medium text-white">Remarks</label>
                        <input type="text" id="remarks" name="remarks" autocomplete="off" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-700 @error('remarks') border-red-500 @else border-gray-600 @enderror placeholder-gray-400 text-white">
                    </div>
                    <div class="mt-3">
                        <label class="block text-sm font-medium text-white" for="invoice">Invoice</label>
                        <input required class="block w-full text-sm border rounded-lg cursor-pointer text-gray-400 focus:outline-none bg-gray-700 border-gray-600 placeholder-gray-400" id="invoice" name="invoice" type="file" accept="image/png, image/jpeg">
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
        <h1 class="mb-1 font-extrabold leading-none text-3xl text-blue-500 tracking-wide">ITEM REQUEST</h1>

        {{-- <!-- ========================================================= Modal toggle ========================================================= -->
        <button id="viewReq" class="hidden text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-800" type="button" data-modal-toggle="itemModal">
        </button>
        
        <!-- ========================================================= Main modal ========================================================= -->
        <div id="itemModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
            <div class="relative w-full h-full max-w-4xl md:h-auto">
                <!-- Modal content -->
                <form enctype="multipart/form-data" action="{{ route('reqItem.statusUpdate') }}" method="POST" class="relative rounded-lg shadow bg-gray-700 text-sm">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t border-gray-600">
                        <h3 class="text-2xl font-semibold text-white leading-5 tracking-wide">
                            @csrf
                            <input type="hidden" id="reqID" name="reqID">
                            <span id="PRNumber"></span>
                            <br>
                            <span id="req_by" class="text-sm"></span><span class="text-sm mx-2">|</span><span id="status" class="text-sm"></span>
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center hover:bg-gray-600 hover:text-white" data-modal-toggle="itemModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4">
                        <div class="grid grid-cols-5 gap-y-3">
                            <div>Item Type: </div>
                            <div id="type" class="col-span-4 font-semibold"></div>
                            <div>Description: </div>
                            <div id="desc" class="col-span-4 font-semibold"></div>
                            <div>Quantity: </div>
                            <div id="quantity" class="col-span-4 font-semibold"></div>
                            <div>Quantity Delivered: </div>
                            <div id="quantity_del" class="col-span-4 font-semibold"></div>
                            <div>Remarks: </div>
                            <div id="remarks" class="col-span-4 font-semibold"></div>
                            <div>Site: </div>
                            <div id="site" class="col-span-4 font-semibold"></div>
                            <div>Date Requested: </div>
                            <div id="date_requested" class="col-span-4 font-semibold"></div>
                            <div>Date Delivered: </div>
                            <div id="date_delivered" class="col-span-4 font-semibold"></div>
                            <div id="updateStatusLabel" class="self-center">Update Status: </div>
                            <div id="updateStatusDiv" class="col-span-4 font-semibold">
                                <select id="updateStatus" name="updateStatus" class="disabled:opacity-50 disabled:pointer-events-none tracking-wider border text-sm rounded-lg block px-2.5 py-2 w-40 h-full bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500">
                                    <option selected value="REQUESTED">REQUESTED</option>
                                    <option value="DELIVERED">DELIVERED</option>
                                    <option value="DECLINED">DECLINED</option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-3 border-t rounded-b border-gray-600">
                        <div id="updateButtonDiv"></div>
                        <button data-modal-toggle="itemModal" type="button" class="focus:ring-4 focus:outline-none rounded-lg border text-sm font-medium px-5 py-2.5 focus:z-10 bg-gray-700 text-gray-300 border-gray-500 hover:text-white hover:bg-gray-600 focus:ring-gray-600">Close</button>
                    </div>
                </form>
            </div>
        </div> --}}

        {{-- CONTROLS --}}
        <div class="my-2">
            {{-- <div class="h-8">
                <a href="{{ route('reqItem.add') }}" type="button" class="h-full text-white focus:ring-4 font-medium rounded-lg text-sm px-10 pt-2 mr-2 mb-2 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-blue-800">New Item Request</a>
            </div> --}}
            {{-- <div class="flex gap-x-3 h-8"> --}}
                {{-- <div class="w-1/3"> --}}
                    {{-- <select id="countries" class="border text-sm rounded-lg block px-2.5 pt-1 pb-0 w-full h-full bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500">
                        <option selected value="">All Item Type</option>
                        @foreach ($types as $type)
                            <option value="{{$type->name}}">{{ ucfirst(strtolower($type->name)) }}</option>
                        @endforeach
                    </select> --}}
                {{-- </div> --}}
                <div class="flex items-center w-1/4">
                    <label for="simple-search" class="sr-only">Search</label>
                    <div class="relative w-full h-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="text" id="tableSearch" autocomplete="off" class="h-full border text-sm rounded-lg block w-full pl-10 p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Search" required>
                    </div>
                </div>
            {{-- </div> --}}
        </div>
        
        {{-- TABLE --}}
        <div style="max-height: calc(100% - 126px);" class="overflow-x-auto relative shadow-md rounded-t-lg">
            <table class="min-w-full text-sm text-left text-gray-400">
                <thead class="relative top-0 text-xs uppercase bg-gray-600 text-gray-400 border-x-8 border-gray-600">
                    <tr class="bg-gray-600 sticky top-0">
                        {{-- <th id="thl" scope="col" class="sticky top-0 py-2 text-center">
                            PR NUMBER
                        </th> --}}
                        <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            ITEM
                        </th>
                        {{-- <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            DESCRIPTION
                        </th> --}}
                        {{-- <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            QUANTITY
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            QUANTITY DELIVERED
                        </th> --}}
                        {{-- <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            REMARKS
                        </th> --}}
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
                            {{-- <th scope="row" class="py-3 px-6 font-medium text-white text-center">
                                {{ $request->pr_no }}
                            </th> --}}
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ $request->item->name }}
                            </td>
                            {{-- <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ $request->brand.' '.$request->description }}
                            </td> --}}
                            {{-- <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ $req->quantity }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ $req->quantity_delivered }}
                            </td> --}}
                            {{-- <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ $request->remarks }}
                            </td> --}}
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
                                {{ strtoupper(date("F j, Y", strtotime($request->date_requested))) }}
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
                            {{-- <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ $req->date_requested }}
                            </td> --}}
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                <button id="viewAttachment" data-path="{{ asset($request->attachment) }}" class="text-blue-500 hover:underline font-semibold">VIEW</button>
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ $request->date_delivered }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                @if ($status == 'PENDING')
                                    <button id="completeButton" data-id="{{ $request->id }}" data-item="{{$request->item->name}}" class="font-medium text-emerald-500 hover:underline">MARK AS DONE</button>
                                    {{-- <a href="{{ url('/request/items/edit/'.$request->id ) }}" class="editButton font-medium text-blue-500 hover:underline">EDIT</a> --}}
                                    {{-- <button data-modal-target="deleteModal" data-modal-toggle="deleteModal" data-id="{{ $request->id }}" data-pr_no="{{ $request->pr_no }}"  class="deleteButton font-medium text-red-500 hover:underline">Delete</button> --}}
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
        });
    </script>
</x-app-layout>
