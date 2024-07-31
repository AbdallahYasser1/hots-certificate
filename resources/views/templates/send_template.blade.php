<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Send Template to Group') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class=" flex flex-col sm:justify-center items-center p-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">

                <form method="POST" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <x-input-label for="group_id" value="Group"/>
                        <select id="group_id" name="group_id" class="block mt-1 w-full">
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button onclick="submitForm({{$template->id}})">
                            Send
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function submitForm($tempId) {
            const form = document.getElementById('template-form');
            const groupId = document.getElementById('group_id').value;
            form.action = `/templates/${$tempId}/group/${groupId}`;
            form.submit();
        }
    </script>
</x-app-layout>