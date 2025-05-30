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


    
    <div id="cancelModal" tabindex="-1" class="fixed top-0 left-0 w-screen h-screen flex items-center justify-center bg-gray-900/30 z-50 hidden">
        <form action="{{ route('request.cancel') }}" method="POST" class="w-96 bg-gray-700 rounded overflow-hidden text-white">
            @csrf
            <div class="p-2 flex items-center justify-between bg-red-500">
                <h1 class="font-semibold text-white">CANCEL REQUEST</h1>
                <button type="button" class="text-gray-300 hover:text-white closeCancelModal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor" class="w-5 h-5">
                        <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
                    </svg>
                </button>
            </div>
            <div class="px-2 py-5">
                <input id="cancelId" item="" name="id" type="hidden">
                <input id="cancelItem" item="" name="item" type="hidden">
                <p class="text-sm">Are you sure you want to delete this request?</p>
            </div>
            <div class="p-2 flex gap-x-2 border-t border-gray-600">
                <button type="submit" class="w-20 py-1 bg-red-500 hover:bg-red-600 rounded">Yes</button>
                <button type="button" class="w-20 py-1 bg-gray-500 hover:bg-gray-600 rounded closeCancelModal">Close</button>
            </div>
        </form>
    </div>

    
    <div id="attachmentModal" tabindex="-1" class="fixed top-0 left-0 w-screen h-screen flex items-center justify-center bg-gray-900/60 z-50 hidden">
        <button id="closeAttachment" class="absolute top-7 right-7 w-10 h-10 rounded-full bg-gray-700 text-white flex items-center justify-center hover:bg-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor" class="w-6 h-6">
                <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
            </svg>
        </button>
        <img id="attachment" src="" alt="" class="max-h-[80%] w-auto object-contain">
    </div>

    <div class="h-[calc(100vh-65px)] p-3 text-gray-200 w-screen">
        <h1 class="mb-1 font-extrabold leading-none text-3xl text-blue-500 tracking-wide">REQUESTS</h1>

        {{-- CONTROLS --}}
        <div class="mt-3">
            <div class="">
                <a href="{{ route('request.add') }}" type="button" class="h-full text-white focus:ring-4 font-medium rounded-lg text-sm px-10 py-2 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-blue-800 leading-4">New Request</a>
            </div>
        </div>
        
        {{-- TABLE --}}
        <div class="max-h-[calc(100%-126px)] overflow-x-auto relative shadow-md rounded-t-lg mt-2 z-40">
            <table class="min-w-full text-sm text-left text-gray-400">
                <thead class="relative top-0 text-xs uppercase bg-gray-600 text-gray-400 border-x-8 border-gray-600">
                    <tr class="bg-gray-600 sticky top-0">
                        <th id="thl" scope="col" class="sticky top-0 py-2 text-center">
                            REQUESTED BY
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            ITEM
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            SITE
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            REQUESTED FOR
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            STATUS
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            Attachment
                        </th>
                        <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                            ACTION
                        </th>
                    </tr>
                </thead>
                <tbody id="itemReqTableBody" class="max-h-[calc(100%-126px)]">
                    @php
                        $x = 1;
                    @endphp
                    @if(count($requests) > 0)
                        @foreach ($requests as $request)
                            <tr class="bg-gray-800 border-gray-700 hover:bg-gray-700">
                                <td class="py-3 px-6 text-center whitespace-nowrap">
                                    {{ $request->requested_by }}
                                </td>
                                <td class="py-3 px-6 text-center whitespace-nowrap">
                                    {{ $request->item }}
                                </td>
                                <td class="py-3 px-6 text-center whitespace-nowrap">
                                    {{ $request->site }}
                                </td>
                                <td class="py-3 px-6 text-center whitespace-nowrap">
                                    {{ $request->requested_for }}
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
                                    <button id="viewAttachment" data-path="{{ $request->attachment }}" class="text-blue-500 hover:underline font-semibold">VIEW</button>
                                </td>
                                <td class="py-3 px-6 text-center whitespace-nowrap">
                                    @if ($request->status != "CANCELLED")
                                        <button id="cancelRequest" data-id="{{ $request->id }}" data-item="{{ $request->item }}" class="text-red-500 hover:underline font-semibold">CANCEL</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center py-2 font-semibold">
                                No data.
                            </td>
                        </tr>
                    @endif
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
            

            jQuery(document).on("click", "#cancelRequest", function(){
                const id = $(this).data('id');
                const item = $(this).data('item');
                $('#cancelId').val(id)
                $('#cancelItem').val(item)
                $('#cancelModal').removeClass('hidden');
            });

            jQuery(document).on("click", ".closeCancelModal", function(){
                $('#cancelModal').addClass('hidden');
            });
        });
    </script>
</x-app-layout>
