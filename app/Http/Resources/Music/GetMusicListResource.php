<?php

namespace App\Http\Resources\Music;

use Illuminate\Http\Resources\Json\JsonResource;

class GetMusicListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'author' => $this->author,
            'tittle'=> $this->title,
            'image' => $this->image,
        ];
    }
}
