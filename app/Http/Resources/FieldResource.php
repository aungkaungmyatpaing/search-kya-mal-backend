<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FieldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $mediaItems = $this->getMedia('field-img');

        // Map the media items to an array of URLs
        $mediaUrls = $mediaItems->map(function ($mediaItem) {
            return $mediaItem->getUrl();
        });
        return [
            'id' => $this->id,
            'type' => new TypeResource($this->type),
            'weekday' => new WeekdayResource($this->weekday),
            'weekend' => new WeekendResource($this->weekend),
            'township' => new TownshipResource($this->township),
            'field_size' => $this->field_size,
            'phone' => $this->phone,
            'facilities' => $this->facilities,
            'description' => $this->description,
            'images' => $mediaUrls,
        ];
    }
}
