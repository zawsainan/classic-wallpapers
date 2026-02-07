<?php

namespace App\Filament\Resources\Pictures\Schemas;

use App\Enums\PictureType;
use App\Models\Tag;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PictureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('type')
                    ->options(PictureType::class)
                    ->required(),
                Select::make('tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->columnSpan(2)
                    ->preload()
                    ->suffixActions([
                        Action::make('select_all')
                            ->icon('heroicon-m-check-circle')
                            ->label('Select All')
                            ->action(function (Select $component) {
                                $component->state(Tag::pluck('id')->toArray());
                            }),
                        Action::make('deselect_all')
                            ->label('Deselect All')
                            ->icon('heroicon-m-x-circle')
                            ->action(function (Select $component) {
                                $component->state([]);
                            })
                    ]),
                FileUpload::make('url')
                    ->columnSpanFull()
                    ->label('Picture')
                    ->disk('public')
                    ->acceptedFileTypes(['image/jpg', 'image/png', 'image/webp'])
                    ->directory('pictures')
                    ->image()
                    ->imageEditor()
                    ->getUploadedFileNameForStorageUsing(fn(TemporaryUploadedFile $file) => $file->getClientOriginalName())
            ])
            ->columns(4);
    }
}
