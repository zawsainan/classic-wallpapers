<?php

namespace App\Filament\Resources\Pictures\Schemas;

use App\Enums\PictureResolution;
use App\Enums\PictureType;
use App\Models\Category;
use App\Models\Tag;
use App\Rules\MatchResolution;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
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
                    ->options(collect(PictureType::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()])->toArray())
                    ->reactive()
                    ->required(),
                Select::make('category_id')
                    ->relationship('category')
                    ->options(Category::pluck('name', 'id')->toArray()),
                Select::make('tags')
                    ->relationship('tags', 'name')
                    ->multiple()
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
                    ->visible(fn($get) => $get('type') == 'other')
                    ->required()
                    ->columnSpanFull()
                    ->label('Picture')
                    ->disk('public')
                    ->acceptedFileTypes(['image/jpg', 'image/png', 'image/webp'])
                    ->directory('pictures')
                    ->image()
                    ->getUploadedFileNameForStorageUsing(fn(TemporaryUploadedFile $file) => $file->getClientOriginalName()),
                Repeater::make('Variants')
                    ->relationship('variants')
                    ->visible(fn($get) => $get('type') == 'wallpaper')
                    ->schema([
                        Select::make('resolution')
                            ->options(collect(PictureResolution::cases())->mapWithKeys(fn($case) => [$case->value => $case->value])),
                        FileUpload::make('url')
                            ->required()
                            ->columnSpanFull()
                            ->label('Picture')
                            ->disk('public')
                            ->acceptedFileTypes(['image/jpg', 'image/png', 'image/webp'])
                            ->directory('pictures')
                            ->image()
                            ->getUploadedFileNameForStorageUsing(fn(TemporaryUploadedFile $file) => $file->getClientOriginalName())
                            ->rules(fn($get) => [new MatchResolution($get('resolution'))])
                    ])
                    ->defaultItems(1)
                    ->addActionLabel('Add Variant')
                    ->columns(4)
                    ->columnSpanFull()
            ])
            ->columns(4);
    }
}
