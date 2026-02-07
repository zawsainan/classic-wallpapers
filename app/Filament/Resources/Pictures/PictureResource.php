<?php

namespace App\Filament\Resources\Pictures;

use App\Filament\Resources\Pictures\Pages\CreatePicture;
use App\Filament\Resources\Pictures\Pages\EditPicture;
use App\Filament\Resources\Pictures\Pages\ListPictures;
use App\Filament\Resources\Pictures\Pages\ViewPicture;
use App\Filament\Resources\Pictures\Schemas\PictureForm;
use App\Filament\Resources\Pictures\Schemas\PictureInfolist;
use App\Filament\Resources\Pictures\Tables\PicturesTable;
use App\Models\Picture;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PictureResource extends Resource
{
    protected static ?string $model = Picture::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Photo;

    public static function form(Schema $schema): Schema
    {
        return PictureForm::configure($schema);
    }



    public static function table(Table $table): Table
    {
        return PicturesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPictures::route('/'),
            'create' => CreatePicture::route('/create'),
            'view' => ViewPicture::route('/{record}'),
            'edit' => EditPicture::route('/{record}/edit'),
        ];
    }
}
