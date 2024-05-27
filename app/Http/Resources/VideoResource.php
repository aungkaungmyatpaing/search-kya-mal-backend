<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'new' => $this->new,
            'category' => $this->category->name,
            'thumb' => $this->getThumbnail()
        ];
    }

    private function getThumbnail()
    {
       if ( $this->getMedia('song-thumbnail')->count() < 1 ) {
            // $videoId = Str::afterLast($this->youtube_link, '/embed/');
            // $videoId = Str::before($videoId, '?');
            $videoId = Str::afterLast($this->youtube_link, 'v=');
            $thumb = 'https://i3.ytimg.com/vi/'.$videoId.'/hqdefault.jpg';
            return $thumb;
       }else{
        return $this->getFirstMediaUrl('song-thumbnail');
       }
    }
}
