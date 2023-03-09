<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @yield('meta')
        <title>Issuance Form</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://unpkg.com/flowbite@1.6.0/dist/flowbite.min.css" />
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/flowbite@1.6.0/dist/flowbite.min.js"></script>
        <script src="https://unpkg.com/flowbite@1.5.3/dist/datepicker.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <style type="text/css" media="print">
        @page 
        {
            size: auto;   /* auto is the initial value */
            margin: 0mm;  /* this affects the margin in the printer settings */
        }
    </style>

    <body onload="window.print()" class="font-sans antialiased w-screen">
        <div class="px-20 mt-3">
            <div class="grid grid-cols-4 gap-x-4">
                <div class="self-center justify-self-end">
                    <img src="{{ asset('storage\images\logo\TMH_BT_RAYMOND.png') }}" class="block w-20 h-auto" alt="">
                </div>
                <div class="col-span-3 self-center">
                    <h1 class=" font-black text-xl tracking-wider">HANDLING INNOVATION INCORPORATED</h1>
                    <p>Dow Jones Bldg., Whse5A, KM 19, WSR, SSH, Parañaque City</p>
                </div>
            </div>
        </div>

        <hr class="mt-2">

        <h1 class="font-medium text-2xl text-center tracking-wider mt-1">ISSUANCE FORM</h1>

        <div class="px-20 mt-2">
            <div class="grid grid-cols-5 gap-x-2 text-sm">
                <div>Name: </div>
                <div class="font-semibold col-span-2 tracking-wide">{{ $item[0]->user}}</div>
                <div>Date Issued: </div>
                <div class="font-semibold tracking-wide">{{ $item[0]->date_issued}}</div>

                <div>Department: </div>
                <div class="font-semibold col-span-2 tracking-wide">{{ $item[0]->department}}</div>
                <div>Location: </div>
                <div class="font-semibold tracking-wide">{{ $item[0]->site}}</div>
            </div>
        </div>

        <hr class="mt-2">

        <div class="px-20 mt-2">
            <div class="grid grid-cols-6 gap-x-2 text-xs">
                <div>Brand Name: </div>
                <div class="font-semibold col-span-3 tracking-wide">{{ $item[0]->desc}}</div>
                <div>Cost: </div>
                <div class="font-semibold tracking-wide">{{ '₱ '.number_format($item[0]->cost, 2, '.', ',')}}</div>
                <div>Serial/SIM No: </div>
                <div class="font-semibold col-span-3 tracking-wide">{{ $item[0]->serial_no}}</div>
                <div>Color: </div>
                <div class="font-semibold tracking-wide">{{ $item[0]->color}}</div>
                <div>Remarks: </div>
                <div class="font-semibold col-span-3 tracking-wide">{{ $item[0]->remarks}}</div>
                <div>Status: </div>
                <div class="font-semibold tracking-wide">{{ $item[0]->status}}</div>

            </div>
        </div>

        <hr class="mt-2">

        <h1 class="font-semibold text-base text-center tracking-wider mt-1">INSTRUCTION FROM HEREIN UNDER IS IMPORTANT. PLEASE READ THEM CAREFULLY</h1>

        <h1>
            
        </h1>

        <script>
            $(document).ready(function(){

            });
        </script>
    </body>
</html>
