<?php

namespace App\Filament\Penghuni\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;

class Profile extends Page implements Forms\Contracts\HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.penghuni.pages.profile';

    protected static ?string $title = 'Profil Saya';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Profil Saya';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::User;

    public ?array $data = [];

    public bool $isEditing = false;

    public function mount(): void
    {
        $this->loadUserData();
    }

    // Load data dari user + penghuni
    public function loadUserData(): void
    {
        $user = auth()->user();
        $penghuni = $user->penghuni;

        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
            'no_hp' => $penghuni->no_hp ?? null,
            'alamat' => $penghuni->alamat ?? null,
        ]);
    }

    public function enableEdit(): void
    {
        $this->isEditing = true;
    }

    public function cancelEdit(): void
    {
        $this->isEditing = false;
        $this->loadUserData();
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Nama')
                ->required()
                ->disabled(fn () => !$this->isEditing),

            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->disabled(fn () => !$this->isEditing),

            Forms\Components\TextInput::make('no_hp')
                ->label('No HP')
                ->disabled(fn () => !$this->isEditing),

            Forms\Components\Textarea::make('alamat')
                ->label('Alamat')
                ->rows(3)
                ->disabled(fn () => !$this->isEditing),

            Forms\Components\TextInput::make('password')
                ->password()
                ->label('Password Baru')
                ->minLength(6)
                ->visible(fn () => $this->isEditing)
                ->dehydrated(fn ($state) => filled($state)),

            Forms\Components\TextInput::make('password_confirmation')
                ->password()
                ->label('Konfirmasi Password')
                ->same('password')
                ->visible(fn () => $this->isEditing)
                ->dehydrated(false),
        ];
    }

    public function submit(): void
    {
        $data = $this->form->getState();
        $user = auth()->user();

        // UPDATE USERS
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        // UPDATE PASSWORD (optional)
        if (!empty($data['password'])) {
            $user->update([
                'password' => Hash::make($data['password'])
            ]);
        }

        // UPDATE PENGHUNI (INI YANG MASUK KE ADMIN)
        $penghuni = $user->penghuni;

        if ($penghuni) {
            $penghuni->update([
                'nama' => $data['name'],
                'no_hp' => $data['no_hp'],
                'alamat' => $data['alamat'],
            ]);
        }

        // UI
        $this->isEditing = false;

        Notification::make()
            ->title('Profil berhasil diperbarui')
            ->success()
            ->send();
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }
}