<div class="p-2 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

    <div class="mt-4 text-2xl font-medium text-gray-900 flex justify-between">
        <div>{{ __('Genres') }}</div>
        <div class="mr-2">
            <x-add-button wire:click="confirmGenreAdd">
                {{ __('Add') }}
            </x-add-button>
        </div>
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
                            <x-edit-button wire:click="confirmGenreEdit ({{ $genre->id }})">{{ __('Edit') }}
                            </x-edit-button>
                            <x-danger-button wire:click="confirmGenreDeletion ({{ $genre->id }})"
                                wire:loading.attr="disabled">{{ __('Remove') }}</x-danger-button>
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

    <x-dialog-modal wire:model="confirmingGenreAdd">
        <x-slot name="title">
            {{ isset($this->genre->id) ? __('Edit genre') : __('Add genre') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4 mt-4">
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="genre.name" type="text" class="mt-1 block w-full" wire:model.defer="genre.name" />
                <x-input-error for="genre.name" class="mt-2" />
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingGenreAdd', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            @if (isset($this->genre->id))
                <x-edit-button class="ml-3" wire:click="addGenre" wire:loading.attr="disabled">
                    {{ __('Save changes') }}
                </x-edit-button>
            @else
                <x-add-button class="ml-3" wire:click="addGenre" wire:loading.attr="disabled">
                    {{ __('Add') }}
                </x-add-button>
            @endif
        </x-slot>
    </x-dialog-modal>

</div>
