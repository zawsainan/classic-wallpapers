<?php

namespace App\Models;

use App\Enums\PictureType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Picture extends Model
{
    protected $fillable = [
        'url',
        'type'
    ];

    protected $casts = [
        'type' => PictureType::class
    ];


    protected function typeLabel(): Attribute
    {
        return Attribute::get(fn() => $this->type?->label());
    }

    public function variants(): HasMany
    {
        return $this->hasMany(PictureVariant::class)->chaperone();
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'picture_tag');
    }
}
