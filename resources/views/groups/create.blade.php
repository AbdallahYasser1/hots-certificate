<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Group') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class=" flex flex-col sm:justify-center items-center p-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">

                <form action="{{ route('groups.store') }}" method="POST">
                    @csrf

                    <div>
                        <x-input-label for="name" value="Group Name"/>
                        <x-text-input id="name" name="name" value="{{ old('name') }}" type="text" required
                                      class="block mt-1 w-full"/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>
                    <div class="mt-4">
                        <x-input-label for="name" value="Description"/>
                        <x-text-input id="name" name="description" value="{{ old('description') }}" type="text" required
                                      class="block mt-1 w-full"/>
                        <x-input-error :messages="$errors->get('description')" class="mt-2"/>
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