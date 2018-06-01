<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Book extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'author' => $this->author,
            'name' => $this->name,
            'page_number' => $this->page_number
        ];
    }

    // public function with($request) {
    //     return [
    //         'version' => '1.0.0'
    //     ];
    // }
}
