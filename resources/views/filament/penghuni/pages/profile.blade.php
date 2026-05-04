<x-filament::page>

    <form wire:submit.prevent="submit">
        {{ $this->form }}

        {{-- Tombol edit --}}
        <div class="mt-6 flex gap-2">

            {{-- MODE VIEW --}}
            @if (!$isEditing)
                <x-filament::button wire:click="enableEdit" color="warning">
                    Edit Profil
                </x-filament::button>
            @endif

            {{-- MODE EDIT --}}
            @if ($isEditing)
                <x-filament::button type="submit">
                    Simpan Perubahan
                </x-filament::button>

                <x-filament::button wire:click="cancelEdit" color="gray">
                    Batal
                </x-filament::button>
            @endif

        </div>
    </form>

</x-filament::page>