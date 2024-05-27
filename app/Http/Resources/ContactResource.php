<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'phone_1' => $this->phone_1,
            'phone_2' => $this->phone_2,
            'email' => $this->email,
            'address' => $this->address,
            'facebook_link' => $this->facebook_link,
            'messenger_link' => $this->messenger_link,
            'viber_link' => $this->viber_link,
        ];
    }
}
