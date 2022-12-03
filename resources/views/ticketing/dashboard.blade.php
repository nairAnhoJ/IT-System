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
    <h1 class="mb-3 font-extrabold leading-none text-3xl text-blue-500 tracking-wide">TICKETING</h1>

        {{-- STEPPER TICKET PROGRESS --}}
        {{-- <div class="mx-4 p-4">
            <div class="flex items-center">
                <div class="flex items-center text-white relative">
                    <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 bg-teal-600 border-teal-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"  class="w-full h-full feather feather-mail">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>                                
                    </div>
                    <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-teal-600">Pending</div>
                </div>
                <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-gray-400"></div>
                <div class="flex items-center text-gray-400 relative">
                    <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 border-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"  class="w-full h-full feather feather-mail">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </div>
                    <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-gray-400">Ongoing</div>
                </div>
                <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-gray-400"></div>
                <div class="flex items-center text-gray-400 relative">
                    <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 border-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"  class="w-full h-full feather feather-mail">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>                  
                    </div>
                    <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-gray-400">Done</div>
                </div>
            </div>
        </div> --}}

        {{-- CONTROLS --}}
        <div class="grid grid-cols-2 mb-0 h-10">
                <div class="h-8">
                    @if ($userDept != 'IT')
                        <a href="{{ route('ticket.create') }}" type="button" class="h-full text-white focus:ring-4 font-medium rounded-lg text-sm px-10 pt-2 mr-2 mb-2 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-blue-800">Create Ticket</a>
                    @endif
                </div>
            <div class="flex gap-x-3 h-8">
                <div class="w-1/3 flex">
                    <label for="status" class="mr-3 self-center">Status: </label>
                    <select id="status" class="block border text-sm rounded-lg px-2.5 pt-1 pb-0 w-full h-full bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500">
                        <option selected value="all">All</option>
                        <option value="proc">Pending</option>
                        <option value="mobo">Ongoing</option>
                        <option value="ram">Done</option>
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
                          TICKET #
                      </th>
                      <th scope="col" class="sticky top-0 py-2 text-center">
                          REQUESTER
                      </th>
                      <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                          DEPARTMENT
                      </th>
                      <th scope="col" class="sticky top-0 py-2 text-center">
                          DATE CREATED
                      </th>
                      <th scope="col" class="sticky top-0 py-2 text-center">
                          NATURE OF PROBLEM
                      </th>
                      <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                          IN-CHARGE
                      </th>
                      <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                          STATUS
                      </th>
                  </tr>
              </thead>
              <tbody id="ticketTableBody" style="max-height: calc(100% - 126px);">
                <tr class="bg-gray-800 border-gray-700 hover:bg-gray-700 cursor-pointer">
                    <th scope="row" class="py-3 px-6 font-medium text-white text-center">
                        <span data-id="123456">
                            123456
                        </span>
                    </th>
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        JOHN ARIAN MALONDRAS
                    </td>
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        IT
                    </td>
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        12/03/2022
                    </td>
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        PRINTER
                    </td>
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        JOHN ARIAN
                    </td>
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        <span class="
                            @php
                                $status = 'ONGOING';
                                if($status == 'PENDING'){
                                    echo 'text-red-500';
                                }elseif($status == 'ONGOING'){
                                    echo 'text-amber-300';
                                }elseif($status == 'DONE'){
                                    echo 'text-teal-500';
                                }
                            @endphp
                        ">
                            @php
                                echo $status;
                            @endphp
                        </span>
                    </td>
                </tr>


                  {{-- @foreach ($items as $item)
                      <tr class="bg-gray-800 border-gray-700 hover:bg-gray-700">
                          <th scope="row" class="py-3 px-6 font-medium text-white text-center">
                              {{ $x++ }}
                          </th>
                          <td class="py-3 px-6 text-center whitespace-nowrap">
                              {{ $item->type }}
                          </td>
                          <td class="py-3 px-6 text-center whitespace-nowrap">
                              {{ $item->code }}
                          </td>
                          <td class="py-3 px-6 text-center whitespace-nowrap">
                              {{ $item->brand }}
                          </td>
                          <td class="py-3 px-6 text-center whitespace-nowrap">
                              {{ $item->description }}
                          </td>
                          <td class="py-3 px-6 text-center whitespace-nowrap">
                              {{ $item->serial_no }}
                          </td>
                          <td class="py-3 px-6 text-center whitespace-nowrap">
                              {{ $item->date_purchased }}
                          </td>
                          <td class="py-3 px-6 text-center whitespace-nowrap">
                              {{ $item->status }}
                          </td>
                          <td class="py-3 px-6 text-center whitespace-nowrap">
                              {{ $item->comp }}
                          </td>
                          <td class="py-3 px-6 text-center whitespace-nowrap">
                              {{ $item->site }}
                          </td>
                          <td class="py-3 px-6 text-center whitespace-nowrap">
                              <a href="#" class="font-medium text-blue-500 hover:underline">Edit</a> | 
                              <a href="#" class="font-medium text-red-500 hover:underline">Delete</a>
                          </td>
                      </tr>
                  @endforeach --}}
              </tbody>
          </table>
      </div>

  </div>

  <script>
    $(document).ready(function(){
        $('#ticketTableBody tr').click(function() {
            $id = $(this).find("span").data('id');
            alert($id);
        });

        // $('.viewTicket').click(function(){
        //     $id = $(this).data('id');
        //     alert($id);
        // });
    });
  </script>
</x-app-layout>
