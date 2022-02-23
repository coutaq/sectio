<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'sectionActivities' => SectionActivityCollection::make($this->whenLoaded('sectionActivities')),
            'admins' => UserCollection::make($this->whenLoaded('admins')),
            'pupils' => UserCollection::make($this->whenLoaded('pupils')),
        ];
    }
}
