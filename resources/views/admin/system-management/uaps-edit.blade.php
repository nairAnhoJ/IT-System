<x-app-layout>
    @section('title')
    Settings
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

        .inset-0{
            opacity: 0.5;
        }
    </style>

    <div id="notifMessage" class="absolute top-20 w-full mx-auto"></div>

    <div style="height: calc(100vh - 65px);" class="p-6 text-gray-200 w-screen overflow-x-hidden overflow-y-auto">
        <div class="grid grid-cols-2">
            <div>
                <h1 class="mb-3 font-extrabold leading-none text-3xl text-blue-500 tracking-wide">Edit User Agreement for Phone / SIM Card</h1>
            </div>
            <div class="justify-self-end">
                <a href="{{ route('settings.index') }}" class="inline-block text-center w-28 text-white focus:outline-none focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 bg-gray-600 hover:bg-gray-500 focus:ring-gray-500 border-gray-500">Back</a>
            </div>
        </div>
        <form action="" id="frmAUD" method="post">
            @csrf
            <div class="mt-10 mb-5">
                <textarea id="uad" style="height: 34px;" name="aups" class="block p-2.5 w-full rounded-lg border bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500 resize-none leading-4 text-sm">{{ $settings->user_agreement_phonesim }}</textarea>
            </div>
            <button id="btnTestPrint" class="inline-block text-center w-28 text-white focus:outline-none focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 bg-blue-800 hover:bg-blue-700 focus:ring-blue-700 border-blue-700">Test Print</button>
            <button id="btnSave" class="inline-block text-center w-28 text-white focus:outline-none focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 bg-blue-800 hover:bg-blue-700 focus:ring-blue-700 border-blue-700">Save & Exit</button>
        </form>
    </div>

    <script>
        $(document).ready(function(){
            var sh = $('#uad').prop('scrollHeight');
            $('#uad').height((sh+10)+'px');

            $('#uad').keyup(function(){
                $(this).height('5px');
                var sh = $(this).prop('scrollHeight');
                $(this).height((sh+10)+'px');
            });

            $('#btnTestPrint').click(function(){ target='_blank'
                $('#frmAUD').prop('action', `{{ route('settings.uapsTest') }}`);
                $('#frmAUD').prop('target', '_blank');
                $('#frmAUD').submit();
            });

            $('#btnSave').click(function(){ target='_blank'
                $('#frmAUD').prop('action', `{{ route('settings.uapsupdate') }}`);
                $('#frmAUD').submit();
            });
        });
    </script>
</x-app-layout>
