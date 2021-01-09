<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'lastname'   => $this->lastname,
            'firstname'  => $this->firstname,
            'name'       => $this->name,
            'slug'       => $this->slug,
        ];
    }
}
