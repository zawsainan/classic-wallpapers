<?php

namespace App\Enums;

enum PictureType: string
{
    case WALLPAPER = 'wallpaper';
    case OTHER = 'other';

    public function label()
    {
        return match ($this) {
            self::WALLPAPER => 'Wallpaper',
            self::OTHER => 'Other'
        };
    }
}
