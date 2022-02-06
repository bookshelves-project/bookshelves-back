<?php

namespace App\Http\Queries;

use App\Exports\TagExport;
use App\Http\Resources\Admin\TagResource;
use App\Models\TagExtend;
use App\Support\GlobalSearchFilter;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TagQuery extends BaseQuery
{
    public function make(): self
    {
        $this->query = QueryBuilder::for(TagExtend::class)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['name',  'slug', 'type'])),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('type'),
                AllowedFilter::partial('books_count'),
                AllowedFilter::partial('series_count'),
                AllowedFilter::partial('first_char'),
            ])
            ->allowedSorts(['id', 'name', 'slug', 'type', 'first_char', 'books_count', 'series_count', 'created_at', 'updated_at'])
            ->with('books', 'series')
            ->withCount('books', 'series')
            ->orderByDesc('id')
        ;

        $this->export = new TagExport($this->query);
        $this->resource = 'tags';

        return $this;
    }

    public function collection(): AnonymousResourceCollection
    {
        return TagResource::collection($this->paginate());
    }

    public function get(): array
    {
        return [
            'sort' => request()->get('sort', '-id'),
            'filter' => request()->get('filter'),
            'tags' => fn () => $this->collection(),
        ];
    }
}