<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'cover_image' => $this->cover_image,
            'description' => $this->when($request->route()->parameter('id'), $this->description),
            'authors' => $this->authors()->implode('name', ','),
            'genres' => $this->genres()->implode('name', ','),

        ];
    }
}
