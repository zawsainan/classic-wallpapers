<?php

namespace App\Filament\Resources\Pictures\Pages;

use App\Filament\Resources\Pictures\PictureResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPicture extends ViewRecord
{
    protected static string $resource = PictureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
