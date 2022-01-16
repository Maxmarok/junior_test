<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Request;
class MusicResource extends JsonResource
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
            'title' => $this->title,
            'author' => $this->author,
            'album' => $this->album,
            'image' =>$request->getSchemeAndHttpHost()."/public".$this->image,
            'url' => $this->url
        ];
    }
}
