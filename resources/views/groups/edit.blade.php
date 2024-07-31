<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update Group') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class=" flex flex-col sm:justify-center items-center p-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                <a href="{{route('groups.show',$group) }}">
                    <x-secondary-button class="btn btn-secondary mb-4">Back</x-secondary-button>
                </a>

                <form action="{{ route('groups.update',$group) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label class="font-semibold text-white mb-4"> {{$group->name}}</label>

                    <div class="mt-4">
                        <x-input-label for="name" value="Group Name"/>
                        <x-text-input id="name" name="name" value="{{ old('name',$group->name) }}" type="text" required
                                      class="block mt-1 w-full"/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>
                    <div class="mt-4">
                        <x-input-label for="name" value="Description"/>
                        <x-text-input id="name" name="description" value="{{ old('description',$group->description) }}"
                                      type="text" required
                                      class="block mt-1 w-full"/>
                        <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>
                            Update
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>