<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EntityResource;
use App\Http\Resources\Tag\TagLightResource;
use App\Http\Resources\Tag\TagResource;
use App\Models\Book;
use App\Models\TagExtend;
use App\Query\QueryBuilderAddon;
use App\Query\QueryExporter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\Tags\Tag;

/**
 * @group Tag
 */
class TagController extends Controller
{
    /**
     * GET Tag collection.
     *
     * Get all Tags ordered by 'name'.
     *
     * @queryParam type filters[tag,genre] Type of Tag, 'tag' by default. No-example
     *
     * @responseField name string Tag's name.
     *
     * @responseFile public/assets/responses/tags.index.get.json
     */
    public function index(Request $request)
    {
        $type = $request->get('type') ? $request->get('type') : 'tag';

        /** @var QueryBuilder $query */
        $query = QueryBuilderAddon::for(TagExtend::class, withCount: ['books'])
            ->allowedFilters([
                AllowedFilter::scope('negligible', 'whereIsNegligible'),
                AllowedFilter::scope('type', 'whereTypeIs'),
            ])
            ->allowedSorts([
                'id',
                'name',
            ])
            ->orderBy('slug->en')
        ;

        return QueryExporter::create($query)
            ->resource(TagLightResource::class)
            ->get()
        ;
    }

    /**
     * GET Tag resrouce.
     *
     * Get Tag details.
     *
     * @queryParam type filters[tag,genre] Type of Tag, 'tag' by default. No-example
     *
     * @responseField name string Tag's name.
     *
     * @responseFile public/assets/responses/tags.show.get.json
     */
    public function show(string $tag_slug)
    {
        $tag = Tag::where('slug->en', $tag_slug)->first();

        return TagResource::make($tag);
    }

    /**
     * GET Book collection of Tag.
     *
     * Get all Books of selected Tag.
     *
     * @urlParam tag string Slug of Tag. Example: 'anticipation'
     *
     * @responseFile public/assets/responses/tags.books.get.json
     */
    public function books(string $tag_slug)
    {
        $tag = Tag::where('slug->en', $tag_slug)->first();
        $books_standalone = Book::withAllTags([$tag])->with(['serie', 'authors', 'media'])->orderBy('title_sort')->doesntHave('serie')->get();

        $books_series = Book::withAllTags([$tag])->with(['serie', 'authors', 'media', 'serie.media', 'serie.authors'])->has('serie')->orderBy('title_sort')->get();
        $series = collect();
        $books_series->each(function ($book) use ($series) {
            $series->add($book->serie);
        });
        $series = $series->unique();

        $books = $books_standalone->merge($series);
        $books = $books->sortBy('title_sort');

        return EntityResource::collection($books->paginate(32));
    }
}
