<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Field extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'type_id',
        'weekday_id',
        'weekend_id',
        'region_id',
        'township_id',
        'field_size',
        'phone',
        'facilities',
        'description',
    ];


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('field-img')
            ->useFallbackUrl(asset('/assets/images/default.png'))
            ->acceptsFile(function (File $file) {
                $allowedMimeTypes = [
                    'image/jpeg',
                    'image/jpg',
                    'image/png',
                    'image/webp',
                ];
                return in_array($file->mimeType, $allowedMimeTypes);
            })
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->width(100)
                    ->height(100);
            });
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function weekday()
    {
        return $this->belongsTo(Weekday::class);
    }

    public function weekend()
    {
        return $this->belongsTo(Weekend::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function township()
    {
        return $this->belongsTo(Township::class);
    }
}
