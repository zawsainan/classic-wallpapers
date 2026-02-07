<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PictureVariant extends Model
{
    protected $fillable = [
        'url',
        'resolution',
        'picture_id'
    ];

    public function picture(): BelongsTo
    {
        return $this->belongsTo(Picture::class);
    }
}
