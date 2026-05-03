<?php

namespace App\Filament\Penghuni\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;

class Profile extends Page implements Forms\Contracts\HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.penghuni.pages.profile';

    protected static ?string $title = 'Profil Saya';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Profil Saya';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::User;

    // // 🔥 data form
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    // // 🔥 isi awal
    public function mount(): void
    {
        $this->form->fill([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ]);
    }

    // // 🔥 form schema
    protected function getFormSchema(): array
    {
        return [
            Section::make('Data Profil')
                ->schema([
                    TextInput::make('name')
                        ->label('Nama')
                        ->required(),

                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required(),

                    TextInput::make('password')
                        ->label('Password Baru')
                        ->password()
                        ->dehydrated(fn ($state) => filled($state)),

                    TextInput::make('password_confirmation')
                        ->label('Konfirmasi Password')
                        ->password()
                        ->same('password'),
                ]),
        ];
    }

    // // 🔥 simpan
    public function submit(): void
    {
        $data = $this->form->getState();

        unset($data['password_confirmation']);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        auth()->user()->update($data);

        Notification::make()
            ->title('Profil berhasil diperbarui')
            ->success()
            ->send();
   }
}