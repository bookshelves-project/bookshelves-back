<?php

namespace App\Http\Resources\Author;

use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Serie\SerieLightResource;
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
        /** @var Author $author */
        $author = $this;

        $resource = AuthorLightResource::make($author)->toArray($request);
        $resource = array_merge($resource, [
            'size'        => $author->size,
            'download'    => $author->download_link,
            'series'      => SerieLightResource::collection($author->series),
            'books'       => BookLightResource::collection($author->books),
        ]);

        return $resource;
    }
}