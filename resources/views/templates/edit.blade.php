<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Group') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class=" flex flex-col sm:justify-center items-center p-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">

                <form action="{{ route('templates.update',$template) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label for="name" value="Template Name"/>
                        <x-text-input id="name" name="name" value="{{ old('name',$template->name) }}" type="text"
                                      required
                                      class="block mt-1 w-full"/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>
                    <div class="mt-4">
                        <x-input-label for="name" value="Description"/>
                        <x-text-input id="name" name="description"
                                      value="{{ old('description',$template->description)}}" type="text" required
                                      class="block mt-1 w-full"/>
                        <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                    </div>
                    <div class="mb-4 mt-4">
                        <x-input-label for="template" value="Template File"/> {{-- Label for info file --}}
                        <label class="block mt-2">
                            <span class="sr-only">Choose file</span> {{-- Screen reader text --}}
                            <input type="file" id="template" name="template"
                                   accept=".pdf,.docx,.doc,.xlsx,.xls,.csv"
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
                            Save
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>