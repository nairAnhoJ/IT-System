<x-app-layout>
    @section('title')
    Phone / SIM Report
    @endsection

    <div style="height: calc(100vh - 65px);" class="p-3 text-gray-200 w-screen">
        <form action="{{ route('phoneSim.report.generate') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="item" class="block mb-2 text-sm font-medium text-white">Item</label>
                <select id="item" name="item" autocomplete="off" class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" :value="old('department')">
                    <option value="">PHONE AND SIM</option>
                    <option value="PHONE">PHONE</option>
                    <option value="SIM CARD">SIM</option>
                </select>
            </div>
            <button type="submit" class="text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-800">Submit</button>
        </form>
    </div>

    <script>
        $(document).ready(function(){

        });
    </script>
</x-app-layout>
 