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

                
        <!-- ========================================================= Modal toggle ========================================================= -->
        <button id="viewTicket" class="hidden text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-800" type="button" data-modal-toggle="ticketModal">
        </button>
        
        <!-- ========================================================= Main modal ========================================================= -->
        <div id="ticketModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
            <div class="relative w-full h-full max-w-2xl md:h-auto">
                <!-- Modal content -->
                <div class="relative rounded-lg shadow bg-gray-700 text-sm">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t border-gray-600">
                        <h3 class="text-xl font-semibold text-white leading-5">
                            <span id="ticketNumber"></span>
                            <br>
                            <span id="ticketRequester" class="text-sm"></span><span class="text-sm mx-2">|</span><span id="ticketDepartment" class="text-sm"></span><span class="text-sm mx-2">|</span><span id="ticketDate" class="text-sm">12/06/2022</span>
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center hover:bg-gray-600 hover:text-white" data-modal-toggle="ticketModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-6">
                        <p class="text-base leading-relaxed text-gray-400">
                            With less than a month to go before the European Union enacts new consumer privacy laws for its citizens, companies around the world are updating their terms of service agreements to comply.
                        </p>
                        <p class="text-base leading-relaxed text-gray-400">
                            The European Union’s General Data Protection Regulation (G.D.P.R.) goes into effect on May 25 and is meant to ensure a common set of data rights in the European Union. It requires organizations to notify users as soon as possible of high-risk data breaches that could personally affect them.
                        </p>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-2 border-t rounded-b border-gray-600">
                        <button data-modal-toggle="ticketModal" type="button" class="text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-800">I accept</button>
                        <button data-modal-toggle="ticketModal" type="button" class="focus:ring-4 focus:outline-none rounded-lg border text-sm font-medium px-5 py-2.5 focus:z-10 bg-gray-700 text-gray-300 border-gray-500 hover:text-white hover:bg-gray-600 focus:ring-gray-600">Decline</button>
                    </div>
                </div>
            </div>
        </div>
  

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
                      <th scope="col" class="sticky top-0 py-2 text-center">
                          SUBJECT
                      </th>
                      <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                          ASSIGNED TO
                      </th>
                      <th scope="col" class="sticky top-0 py-2 text-center whitespace-nowrap">
                          STATUS
                      </th>
                  </tr>
              </thead>
              <tbody id="ticketTableBody" style="max-height: calc(100% - 126px);">
                @foreach ($tickets as $ticket)
                    <tr class="bg-gray-800 border-gray-700 hover:bg-gray-700 cursor-pointer">
                        <th scope="row" class="py-3 px-6 font-medium text-white text-center">
                            <span data-id="{{ $ticket->id }}">
                                {{ $ticket->ticket_no }}
                            </span>
                        </th>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            {{ $ticket->user }}
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            {{ $ticket->dept }}
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            {{ $ticket->created_at }}
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            {{ $ticket->nature_of_problem }}
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            {{ $ticket->subject }}
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            {{ $ticket->assigned_to }}
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            <span class="
                                @php
                                    $status = $ticket->status;
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
                @endforeach
              </tbody>
          </table>
      </div>

  </div>

  <script>
    $(document).ready(function(){
        $('#ticketTableBody tr').click(function() {
            $id = $(this).find("span").data('id');
            $('#ticketNumber').html($id);
            $('#ticketRequester').html("John Arian Malondras");
            $('#ticketDepartment').html("IT");
            $('#ticketDate').html("12/06/2022");
            $('#viewTicket').click();
        });

        // $('.viewTicket').click(function(){
        //     $id = $(this).data('id');
        //     alert($id);
        // });
    });
  </script>
</x-app-layout>
