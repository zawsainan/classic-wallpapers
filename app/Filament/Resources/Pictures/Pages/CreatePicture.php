<?php

namespace App\Filament\Resources\Pictures\Pages;

use App\Filament\Resources\Pictures\PictureResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePicture extends CreateRecord
{
    protected static string $resource = PictureResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return "Picture created successfully.";
    }
}
