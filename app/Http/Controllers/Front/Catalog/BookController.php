<?php

namespace App\Http\Controllers\Front\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookResource;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @hideFromAPIDocumentation
 */
#[Prefix('catalog/books')]
class BookController extends Controller
{
    #[Get('/{author}/{book}', name: 'front.catalog.books.show')]
    public function show(Request $request, string $author, string $slug)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $book = Book::whereHas('authors', function ($query) use ($author) {
            return $query->where('author_id', '=', $author->id);
        })->whereSlug($slug)->firstOrFail();
        $book = BookResource::make($book);
        $book = json_decode($book->toJson());

        return view('front.pages.catalog.books._slug', compact('book'));
    }
}
