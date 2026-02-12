<?php

namespace App\Models;

use App\Enums\PictureType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Picture extends Model
{
    use SoftDeletes, HasUlids;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'url',
        'type',
        'name'
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
