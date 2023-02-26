<div class="p-2 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

    <div class="mt-4 text-2xl font-medium text-gray-900">
        <div>Genres</div>
    </div>
    <div class="mt-3">
        <div class="flex justify-between">
            <div>
                <input wire:model.debounce.300ms="search" type="search" placeholder="Search"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="">
            </div>
        </div>
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('id')">Id</button>
                            <x-sort-icon sortField="id" :sortBy="$sortBy" :sortAsc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('name')">Name</button>
                            <x-sort-icon sortField="name" :sortBy="$sortBy" :sortAsc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($genres as $genre)
                    <tr>
                        <td class="rounded border px-4 py-2">{{ $genre->id }}</td>
                        <td class="rounded border px-4 py-2">{{ $genre->name }}</td>
                        <td class="rounded border px-4 py-2">
                            <x-danger-button wire:click="confirmGenreDeletion ({{ $genre->id }})"
                                wire:loading.attr="disabled">
                                {{ __('Remove') }}
                            </x-danger-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $genres }}</div>
    <x-dialog-modal wire:model="confirmingGenreDeletion">
        <x-slot name="title">
            {{ __('Remove') }}
        </x-slot>

        <x-slot name="content">
            Are you sure you want to delete this genre?
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingGenreDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="deleteGenre ({{ $confirmingGenreDeletion }})"
                wire:loading.attr="disabled">
                {{ __('Remove') }}
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>

</div>
