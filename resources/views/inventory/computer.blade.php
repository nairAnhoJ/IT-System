<x-app-layout>
    @section('title')
    Computers
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

    <div style="height: calc(100vh - 65px);" class="p-3 text-gray-200 w-screen">
        <h1 class="mb-1 font-extrabold leading-none text-3xl text-blue-500 tracking-wide">COMPUTERS</h1>

        {{-- VIEW COMPUTER MODAL --}}
            <!-- ========================================================= Modal toggle ========================================================= -->
            <button id="viewComputer" class="hidden text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-800" type="button" data-modal-toggle="computerModal"></button>
            
            <!-- ========================================================= Main modal ========================================================= -->
            <div id="computerModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                <div style="max-height: 85vh;" class="relative w-full h-full max-w-2xl">
                    <!-- Modal content -->
                    <div class="relative rounded-lg shadow bg-gray-700 text-sm">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 border-b rounded-t border-gray-600">
                            <h3 class="text-2xl font-semibold text-white leading-5 tracking-wide">
                                <span id="code"></span>
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center hover:bg-gray-600 hover:text-white" data-modal-toggle="computerModal">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div style="max-height: calc(85vh - 140px);" class="py-4 px-10 overflow-x-auto">
                            <div class="grid grid-cols-5 gap-y-3 text-white">
                                <div class="col-span-5 text-blue-500 font-bold text-2xl tracking-wide italic">DETAILS</div>
                                <div>User: </div>
                                <div id="computerUser" class="col-span-4 font-semibold"></div>
                                <div>IP Address: </div>
                                <div id="computerIP" class="col-span-4 font-semibold"></div>
                                <div>Type: </div>
                                <div id="computerType" class="col-span-4 font-semibold"></div>
                                <div>Status: </div>
                                <div id="computerStatus" class="col-span-4 font-semibold"></div>
                                <div>Site: </div>
                                <div id="computerSite" class="col-span-4 font-semibold"></div>
                                <div>Conducted By: </div>
                                <div id="computerConBy" class="col-span-4 font-semibold"></div>
                                <div>Date Conducted: </div>
                                <div id="computerDateCon" class="col-span-4 font-semibold"></div>
                                <div class="col-span-5 text-blue-500 font-bold text-2xl tracking-wide italic"></div>
                                <div class="col-span-5 text-blue-500 font-bold text-2xl tracking-wide italic"></div>
                                <div class="col-span-5 text-blue-500 font-bold text-2xl tracking-wide italic">SPECS</div>

                                <div>Laptop: </div>
                                <div id="specLaptop" class="col-span-4 font-semibold"></div>
                                <div>Motherboard: </div>
                                <div id="specMobo" class="col-span-4 font-semibold"></div>
                                <div>Processor: </div>
                                <div id="specProc" class="col-span-4 font-semibold"></div>
                                <div>RAM 1: </div>
                                <div id="specRam1" class="col-span-4 font-semibold"></div>
                                <div>RAM 2: </div>
                                <div id="specRam2" class="col-span-4 font-semibold"></div>
                                <div>RAM 3: </div>
                                <div id="specRam3" class="col-span-4 font-semibold"></div>
                                <div>RAM 4: </div>
                                <div id="specRam4" class="col-span-4 font-semibold"></div>
                                <div>Storage 1: </div>
                                <div id="specStore1" class="col-span-4 font-semibold"></div>
                                <div>Storage 2: </div>
                                <div id="specStore2" class="col-span-4 font-semibold"></div>
                                <div>Storage 3: </div>
                                <div id="specStore3" class="col-span-4 font-semibold"></div>
                                <div>Storage 4: </div>
                                <div id="specStore4" class="col-span-4 font-semibold"></div>
                                <div>Graphics Card: </div>
                                <div id="specGpu" class="col-span-4 font-semibold"></div>
                                <div>Power Supply: </div>
                                <div id="specPsu" class="col-span-4 font-semibold"></div>
                                <div>Monitor: </div>
                                <div id="specMonitor" class="col-span-4 font-semibold"></div>
                                <div>Mouse: </div>
                                <div id="specMouse" class="col-span-4 font-semibold"></div>
                                <div>Keyboard: </div>
                                <div id="specKb" class="col-span-4 font-semibold"></div>
                                <div>LAN Card: </div>
                                <div id="specLan" class="col-span-4 font-semibold"></div>
                                <div>Others 1: </div>
                                <div id="specOthers1" class="col-span-4 font-semibold"></div>
                                <div>Others 2: </div>
                                <div id="specOthers2" class="col-span-4 font-semibold"></div>
                                <div>Others 3: </div>
                                <div id="specOthers3" class="col-span-4 font-semibold"></div>
                                <div>Others 4: </div>
                                <div id="specOthers4" class="col-span-4 font-semibold"></div>
                                <div>Others 5: </div>
                                <div id="specOthers5" class="col-span-4 font-semibold"></div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-3 border-t rounded-b border-gray-600">
                            <button data-modal-toggle="computerModal" type="button" class="focus:ring-4 focus:outline-none rounded-lg border text-sm font-medium px-5 py-2.5 focus:z-10 bg-gray-700 text-gray-300 border-gray-500 hover:text-white hover:bg-gray-600 focus:ring-gray-600">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- VIEW COMPUTER MODAL END --}}

        {{-- CONTROLS --}}
        <div class="grid grid-cols-2 mb-0 h-10">
            <div class="h-8">
                <a href="{{ route('computer.add') }}" type="button" class="h-full text-white focus:ring-4 font-medium rounded-lg text-sm px-10 pt-1.5 mr-2 mb-2 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-blue-800">Add Item</a>
            </div>
            <div class="flex gap-x-3 h-8">
                <div class="w-1/3">
                </div>
                <div class="flex items-center w-2/3">
                    <label for="simple-search" class="sr-only">Search</label>
                    <div class="relative w-full h-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="text" id="tableSearch" autocomplete="off" class="h-full border text-sm rounded-lg block w-full pl-10 p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Search" required>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- TABLE --}}
        <div style="max-height: calc(100% - 126px);" class="overflow-x-auto relative shadow-md rounded-t-lg">
            <table class="table-fixed min-w-full text-sm text-left text-gray-400">
                <thead class="relative top-0 text-xs uppercase bg-gray-600 text-gray-400 border-x-8 border-gray-600">
                    <tr class="bg-gray-600 sticky top-0">
                        <th scope="col" class="sticky top-0 py-2 px-3 text-center whitespace-nowrap">
                            CODE
                        </th>
                        <th scope="col" class="sticky top-0 py-2 px-3 text-center whitespace-nowrap">
                            USER
                        </th>
                        <th scope="col" class="sticky top-0 py-2 px-3 text-center whitespace-nowrap">
                            IP ADDRESS
                        </th>
                        <th scope="col" class="sticky top-0 py-2 px-3 text-center whitespace-nowrap">
                            TYPE
                        </th>
                        <th scope="col" class="sticky top-0 py-2 px-3 text-center whitespace-nowrap">
                            STATUS
                        </th>
                        <th scope="col" class="sticky top-0 py-2 px-3 text-center whitespace-nowrap">
                            SITE
                        </th>
                        <th scope="col" class="sticky top-0 py-2 px-3 text-center whitespace-nowrap">
                            CONDUCTED BY
                        </th>
                        <th scope="col" class="sticky top-0 py-2 px-3 text-center whitespace-nowrap">
                            DATE CONDUCTED
                        </th>
                        <th scope="col" class="sticky top-0 py-2 px-3 text-center whitespace-nowrap">
                            ACTION
                        </th>
                    </tr>
                </thead>
                <tbody id="itemTableBody" style="max-height: calc(100% - 126px);">
                    @foreach ($computers as $computer)
                        <tr class="bg-gray-800 border-gray-700 hover:bg-gray-700 cursor-pointer">
                            <th scope="row" class="py-3 px-6 font-medium text-white text-center">
                                <span data-id="{{ $computer->id }}" data-code="{{ $computer->code }}" data-user="{{ $computer->user }}" data-ip_add="{{ $computer->ip_add }}" data-type="{{ $computer->type }}" data-status="{{ $computer->status }}" data-site_name="{{ $computer->site_name }}" data-conducted_by="{{ $computer->conducted_by }}" data-date_conducted="{{ $computer->date_conducted }}">
                                    {{ $computer->code }}
                                </span>
                            </th>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ $computer->user }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ $computer->ip_add }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ $computer->type }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ $computer->status }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ $computer->site_name }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ $computer->conducted_by }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                {{ $computer->date_conducted }}
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                <a href="{{ url('/inventory/computers/edit/'.$computer->id ) }}" class="editButton font-medium text-blue-500 hover:underline">Edit</a> | 
                                <a type="button" data-id="{{ $computer->id }}" data-code="{{ $computer->code }}" class="deleteButton font-medium text-red-500 hover:underline">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $("#tableSearch").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                    $("#itemTableBody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('#itemTableBody tr').click(function() {
                var computerCode = $(this).find("span").data('code');
                $('#code').html(computerCode);

                var computerUser = $(this).find("span").data('user');
                $('#computerUser').html(computerUser);

                var computerIP = $(this).find("span").data('ip_add');
                $('#computerIP').html(computerIP);

                var computerType = $(this).find("span").data('type');
                $('#computerType').html(computerType);

                var computerStatus = $(this).find("span").data('status');
                $('#computerStatus').html(computerStatus);

                var computerSite = $(this).find("span").data('site_name');
                $('#computerSite').html(computerSite);

                var computerConBy = $(this).find("span").data('conducted_by');
                $('#computerConBy').html(computerConBy);

                var computerDateCon = $(this).find("span").data('date_conducted');
                $('#computerDateCon').html(computerDateCon);




                var _token = $('input[name="_token"]').val();
                var computerID = $(this).find("span").data('id');
                $.ajax({
                    url:"{{ route('computer.view') }}",
                    method:"POST",
                    dataType: 'json',
                    data:{
                        computerID: computerID,
                        _token: _token
                    },
                    success:function(result){
                        $('#specLaptop').html(result.specLaptop);
                        $('#specMobo').html(result.specMobo);
                        $('#specProc').html(result.specProc);
                        $('#specRam1').html(result.specRam[0]);
                        $('#specRam2').html(result.specRam[1]);
                        $('#specRam3').html(result.specRam[2]);
                        $('#specRam4').html(result.specRam[3]);
                        $('#specStore1').html(result.specStore[0]);
                        $('#specStore2').html(result.specStore[1]);
                        $('#specStore3').html(result.specStore[2]);
                        $('#specStore4').html(result.specStore[3]);
                        $('#specGpu').html(result.specGpu);
                        $('#specPsu').html(result.specPsu);
                        $('#specMonitor').html(result.specMonitor);
                        $('#specMouse').html(result.specMouse);
                        $('#specKb').html(result.specKB);
                        $('#specLan').html(result.specLan);
                        $('#specKb').html(result.specKB);
                        $('#specOthers1').html(result.specOthers[0]);
                        $('#specOthers2').html(result.specOthers[1]);
                        $('#specOthers3').html(result.specOthers[2]);
                        $('#specOthers4').html(result.specOthers[3]);
                        $('#specOthers5').html(result.specOthers[4]);

                        $('#viewComputer').click();
                    }
                })
            });
        });
    </script>
</x-app-layout>
