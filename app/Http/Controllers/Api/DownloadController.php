<?php

namespace App\Http\Controllers\Api;

use File;
use ZipArchive;
use App\Models\Book;
use App\Models\Serie;
use App\Models\Author;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\MediaLibrary\Support\MediaStream;

class DownloadController extends Controller
{
    public function book(Request $request, string $author, string $book)
    {
        $book = Book::whereSlug($book)->firstOrFail();
        if ($book->author->slug === $author) {
            $epub = $book->getMedia('books_epubs')->first();
        } else {
            return response()->json(['Error' => 'Book not found'], 401);
        }

        return response()->download($epub->getPath(), $epub->file_name);
    }

    public function serie(string $serie)
    {
        $books_epubs = [];
        $serie = Serie::with('books')->whereSlug($serie)->firstOrFail();
        foreach ($serie->books as $key => $book) {
            $epub = $book->getMedia('books_epubs')->first();
            array_push($books_epubs, $epub);
        }

        $token = Str::random(8);
        $token = strtolower($token);
        $dirname = "$serie->slug-$token";

        return MediaStream::create("$dirname.zip")->addMedia($books_epubs);
    }

    public function author(string $author)
    {
        $books_epubs = [];
        $author = Author::with('books')->whereSlug($author)->firstOrFail();
        foreach ($author->books as $key => $book) {
            $epub = $book->getMedia('books_epubs')->first();
            array_push($books_epubs, $epub);
        }

        $token = Str::random(8);
        $token = strtolower($token);
        $dirname = "$author->slug-$token";

        return MediaStream::create("$dirname.zip")->addMedia($books_epubs);
    }

    /**
     * Old download method.
     */
    public function getZip(string $model_name, string $slug)
    {
        $modelName = '\App\Models'.'\\'.$model_name;
        $model = $modelName::with('books')->whereSlug($slug)->firstOrFail();

        try {
            $token = Str::random(8);
            $token = strtolower($token);
            $dirname = "$model->slug-$token";
            $path = public_path("storage/$dirname");
            if (! File::exists($path)) {
                File::makeDirectory($path);
            }

            $downloadList = [];
            foreach ($model->books->toArray() as $key => $book) {
                $path = str_replace('storage/', '', $book['epub']['name']);
                array_push($downloadList, $path);
            }
            foreach ($downloadList as $key => $epub) {
                File::copy(public_path("storage/books/$epub"), public_path("storage/$dirname/$epub"));
            }

            $zip = new ZipArchive();
            $fileName = $dirname.'.zip';

            if (true === $zip->open(public_path('storage/'.$fileName), ZipArchive::CREATE)) {
                $files = File::files(public_path("storage/$dirname"));

                foreach ($files as $key => $value) {
                    $relativeNameInZipFile = basename($value);
                    $zip->addFile($value, $relativeNameInZipFile);
                }

                $zip->close();
            }

            File::deleteDirectory(public_path("storage/$dirname"));

            return public_path("storage/$dirname.zip");
        } catch (\Throwable $th) {
            return response()->json('Unexpected error!');
        }
    }
}
