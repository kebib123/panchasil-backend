<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class News extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'category'=>$this->categories,
            'description'=>$this->description,
            'status'=>$this->status,
            'author'=>$this->author,
            'taja_khabar'=>$this->taja_khabar,
            'headline'=>$this->headline,
            'related'=>$this->related,
            'image'=>$this->image,
            'path'=>'public/images/news/'.$this->image,
        ];
    }
}
