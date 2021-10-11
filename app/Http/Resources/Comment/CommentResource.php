<?php

namespace App\Http\Resources\Comment;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Comment $resource
 */
class CommentResource extends JsonResource
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
        $for = strtolower(str_replace('App\\Models\\', '', $this->resource->commentable_type));
        $entity = $this->resource->commentable;
        $title = null;

        switch ($for) {
            case 'book':
                $title = $entity->title;

                break;

            case 'serie':
                $title = $entity->title;

                break;

            case 'author':
                $title = $entity->name;

                break;

            default:
                $title = null;

                break;
        }

        return [
            'meta' => [
                'type' => 'comment',
                'for' => $for,
                'author' => $this->resource->commentable->meta_author,
                'slug' => $this->resource->commentable->slug,
            ],
            'id' => $this->resource->id,
            'text' => $this->resource->text,
            'rating' => $this->resource->rating ? $this->resource->rating : null,
            'user' => [
                'id' => $this->resource->user->id,
                'name' => $this->resource->user->name,
                'slug' => $this->resource->user->slug,
                'avatar' => $this->resource->user->avatar,
                'color' => $this->resource->user->color,
            ],
            'createdAt' => $this->resource->created_at,
            'updatedAt' => $this->resource->updated_at,
            'title' => $title,
            'cover' => $this->resource->commentable->cover_thumbnail,
        ];
    }
}