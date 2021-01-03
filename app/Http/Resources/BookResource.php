<?php

namespace App\Http\Resources;

use App\Models\Serie;
use App\Models\Author;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
        $serie = null;
        if ($this->serie_id) {
            $serie = new SerieResource(Serie::find($this->serie_id));
        }
        if ($this->author_id) {
            $author = new AuthorResource(Author::find($this->author_id));
        }

        return [
            'title'        => $this->title,
            'slug'         => $this->slug,
            'author'       => $author ? $author->name : null,
            'description'  => $this->description,
            'language'     => $this->language,
            'publishDate'  => $this->publish_date,
            'isbn'         => $this->isbn,
            'publisher'    => $this->publisher,
            'coverPath'    => $this->cover_path ? config('app.url').'/'.$this->cover_path : null,
            'epubPath'     => config('app.url').'/'.$this->epub_path,
            'serieNumber'  => $this->serie_number ? $this->serie_number : null,
            'serie'        => $serie ? $serie->title : null,
        ];
    }
}
