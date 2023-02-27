<x-app-layout>
    @section('title')
    SAP BP
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

    <div style="height: calc(100vh - 65px);" class="py-4 px-8 text-gray-200 w-screen overflow-x-auto">
        <h1 class="mb-3 font-extrabold leading-none text-3xl text-blue-500 tracking-wide">SAP BUSINESS PARTNER</h1>

            <form action="{{ route('sap.store') }}" method="POST" class="w-full grid grid-cols-9 gap-2 content-center">
                @csrf
                <div class="leading-7 py-px text-sm">Type of Request</div>
                <div class="col-span-2">
                    <select name="type" id="request" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500">
                        <option value="ADD">ADD</option>
                        <option value="UPDATE">UPDATE</option>
                        <option value="ACTIVE">ACTIVE</option>
                        <option value="INACTIVE">INACTIVE</option>
                    </select>
                </div>
                <div class="leading-7 py-px justify-self-end text-sm">Remarks</div>
                <div class="col-span-5">
                    <input type="text" id="remarks" name="remarks" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" autocomplete="off" required>
                </div>

                <div class="col-span-9 my-1">
                    <div class="w-full h-px border-b border-b-gray-500"></div>
                </div>
                
                <div class="leading-7 py-px text-sm">BP Code</div>
                <div class="col-span-2">
                    <input type="text" id="code" name="code" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" autocomplete="off">
                </div>
                <div class="leading-7 py-px justify-self-end text-sm">WTax Code</div>
                <div class="col-span-2">
                    <input type="text" id="wtax_code" name="wtax_code" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" autocomplete="off">
                </div>
                <div class="leading-7 py-px justify-self-end text-sm">AR In-Charge</div>
                <div class="col-span-2">
                    <input type="text" id="AR_inCharge" name="AR_inCharge" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" autocomplete="off">
                </div>



                <div class="leading-7 py-px text-sm">BP Type</div>
                <div class="col-span-2">
                    <select id="type" name="type" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500">
                        <option value="CUSTOMER">CUSTOMER</option>
                        <option value="VENDOR">VENDOR</option>
                    </select>
                </div>
                <div class="leading-7 py-px justify-self-end text-sm">On Hold</div>
                <div class="col-span-2">
                    <select id="isOnHold" name="isOnHold" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500">
                        <option value="1">YES</option>
                        <option value="0">NO</option>
                    </select>
                </div>
                <div class="leading-7 py-px justify-self-end text-sm">AR Email</div>
                <div class="col-span-2">
                    <input type="text" id="AR_email" name="AR_email" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" autocomplete="off">
                </div>



                <div class="leading-7 py-px text-sm">Customer Name</div>
                <div class="col-span-2">
                    <input type="text" name="name" id="name" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" autocomplete="off" required>
                </div>
                <div class="leading-7 py-px justify-self-end text-sm">SOA Auto Email</div>
                <div class="col-span-2">
                    <select id="isAutoEmail" name="isAutoEmail" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500">
                        <option value="1">YES</option>
                        <option value="0">NO</option>
                    </select>
                </div>
                <div class="leading-7 py-px justify-self-end text-sm">Payment Terms</div>
                <div class="col-span-2">
                    <input type="text" id="payment_terms" name="payment_terms" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" autocomplete="off">
                </div>



                <div class="leading-7 py-px text-sm">Billing Address</div>
                <div class="col-span-2">
                    <input type="text" id="billing_address" name="billing_address" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" autocomplete="off">
                </div>
                <div class="leading-7 py-px justify-self-end text-sm">Business Style</div>
                <div class="col-span-2">
                    <input type="text" id="style" name="style" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" autocomplete="off">
                </div>
                <div class="leading-7 py-px justify-self-end text-sm">BIR 2303</div>
                <div class="col-span-2">
                    <input style="height: 30px;" name="bir_attachment" class="block w-full text-xs border rounded-lg cursor-pointer text-gray-400 focus:outline-none bg-gray-700 border-gray-600 placeholder-gray-400" id="bir_attachment" type="file">
                </div>



                <div class="leading-7 py-px text-sm">Shipping Address</div>
                <div class="col-span-2">
                    <input type="text" id="shipping_address" name="shipping_address" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" autocomplete="off">
                </div>
                <div class="leading-7 py-px justify-self-end text-sm">Contact Name</div>
                <div class="">
                    <input type="text" id="contact_name1" name="contact_name1" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" autocomplete="off">
                </div>
                <div class="leading-7 py-px justify-self-end text-sm">Contact No</div>
                <div class="">
                    <input type="text" id="contact_no1" name="contact_no1" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" autocomplete="off">
                </div>
                <div class="leading-7 py-px justify-self-end text-sm">Contact Email</div>
                <div class="">
                    <input type="text" id="contact_email1" name="contact_email1" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" autocomplete="off">
                </div>



                <div class="leading-7 py-px text-sm">TIN</div>
                <div class="col-span-2">
                    <input type="text" id="tin" name="tin" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" autocomplete="off">
                </div>
                <div class="leading-7 py-px justify-self-end text-sm">Contact Name</div>
                <div class="">
                    <input type="text" id="contact_name2" name="contact_name2" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" autocomplete="off">
                </div>
                <div class="leading-7 py-px justify-self-end text-sm">Contact No</div>
                <div class="">
                    <input type="text" id="contact_no2" name="contact_no2" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" autocomplete="off">
                </div>
                <div class="leading-7 py-px justify-self-end text-sm">Contact Email</div>
                <div class="">
                    <input type="text" id="contact_email2" name="contact_email2" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" autocomplete="off">
                </div>



                <div class="leading-7 py-px text-sm">Sales Employee</div>
                <div class="col-span-2">
                    <input type="text" id="sales_employee" name="sales_employee" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" autocomplete="off">
                </div>
                <div class="leading-7 py-px justify-self-end text-sm">Contact Name</div>
                <div class="">
                    <input type="text" id="contact_name3" name="contact_name3" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" autocomplete="off">
                </div>
                <div class="leading-7 py-px justify-self-end text-sm">Contact No</div>
                <div class="">
                    <input type="text" id="contact_no3" name="contact_no3" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" autocomplete="off">
                </div>
                <div class="leading-7 py-px justify-self-end text-sm">Contact Email</div>
                <div class="">
                    <input type="text" id="contact_email3" name="contact_email3" class="border text-sm rounded-lg block w-full px-2.5 py-1 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" autocomplete="off">
                </div>

                <button type="submit" class="text-white focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 mt-2 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-blue-800">Create Ticket</button>
            </form>


            <div class="my-5">
                <div class="w-full h-px border-b border-b-gray-500"></div>
            </div>
            

            <div class="mb-2">
                <label for="default-search" class="mb-2 text-sm font-medium sr-only text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="search" id="search" class="block w-1/4 py-1.5 my-0.5 pl-10 text-sm border rounded-lg bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Search" required>
                </div>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-400">
                    <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-1">
                                #
                            </th>
                            <th scope="col" class="px-6 py-1">
                                BP CODE
                            </th>
                            <th scope="col" class="px-6 py-1">
                                CUSTOMER NAME
                            </th>
                            <th scope="col" class="px-6 py-1">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody id="sapTable">
                        @php
                            $x = 1;   
                        @endphp
                        @foreach ($sapbps as $sapbp)
                            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <th scope="row" class="px-6 py-1.5 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <span>
                                        {{ $x++ }}
                                    </span>
                                </th>
                                <td class="px-6 py-1.5">
                                    {{ $sapbp->code }}
                                </td>
                                <td class="px-6 py-1.5">
                                    {{ $sapbp->name }}
                                </td>
                                <td class="px-6 py-1.5">
                                    <a data-id="{{ $sapbp->id }}" href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

    </div>

    <script>
        $(document).ready(function(){
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#sapTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</x-app-layout>