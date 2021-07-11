<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <p class="text-green-600">Create a new job</p>
        </h2>
    </x-slot> --}}
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
            <p class="text-indigo-600 font-semibold text-xl">Create a new job</p>
        </div>
    </header>


    <div class="container my-3">
        <h2 class="text-gray-600" style="font-size:25px">Fill-in the form to create a new offer
        </h2>


        
        @livewire('job-creations')
    </div>

    {{-- @section('scripts')
        <script>
            ClassicEditor
                .create(document.querySelector('#job-textarea'))
                .catch(error => {
                    console.error(error);
                });

        </script>
    @endsection --}}

</x-app-layout>
