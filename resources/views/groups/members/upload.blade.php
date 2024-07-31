<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Import Members') }}
        </h2>
    </x-slot>
    @if (session('error'))
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-red-600 dark:text-red-100">
                        {{ session('error') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class=" flex flex-col sm:justify-center items-center p-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
              <a href="{{route('groups.show',$group) }}">  <x-secondary-button  class="btn btn-secondary mb-4">Back</x-secondary-button></a>
                <form action="{{ route('members.import',$group) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label class="font-semibold text-white mb-4"> {{$group->name}}</label>
                    <div class="mb-4 mt-4">
                        <x-input-label for="csv_file" value="CSV File"/> {{-- Label for info file --}}
                        <label class="block mt-2">
                            <span class="sr-only">Choose file</span> {{-- Screen reader text --}}
                            <input type="file" id="csv_file" name="csv_file" accept=".pdf,.docx,.doc,.xlsx,.xls,.csv"
                                   class="block w-full text-sm text-slate-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-violet-50 file:text-violet-700
                                    hover:file:bg-violet-100
                                "/>
                        </label>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>
                            Import Members
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>