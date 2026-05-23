<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                FileUpload::make('avatar_url')
                    ->label('Foto Profil (Avatar)')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios(['1:1'])
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->directory('avatars')
                    ->maxSize(2048)
                    ->avatar(),
                $this->getPasswordConfirmationFormComponent(),
                $this->getCurrentPasswordFormComponent(),
                TextInput::make('title')
                    ->label('Jabatan')
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Nomor Telepon / WA')
                    ->tel()
                    ->maxLength(255),
                Textarea::make('address')
                    ->label('Alamat Lengkap')
                    ->rows(3),
                Textarea::make('bio')
                    ->label('Bio / Catatan Singkat')
                    ->rows(3),
            ]);
    }
}
