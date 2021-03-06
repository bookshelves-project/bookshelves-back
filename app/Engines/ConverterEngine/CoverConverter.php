<?php

namespace App\Engines\ConverterEngine;

use App\Engines\ConverterEngine;
use App\Enums\MediaDiskEnum;
use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use App\Services\ConsoleService;
use App\Services\DirectoryParserService;
use App\Services\MediaService;
use ReflectionClass;

class CoverConverter
{
    /**
     * Generate Book image from original cover string file.
     * Manage by spatie/laravel-medialibrary.
     */
    public static function create(ConverterEngine $converter): Book
    {
        if (! $converter->default
            && ! $converter->book->cover_book
            && ! empty($converter->parser->cover_file)
        ) {
            try {
                MediaService::create($converter->book, $converter->book->slug, MediaDiskEnum::cover)
                    ->setMedia($converter->parser->cover_file)
                    ->setColor()
                ;
            } catch (\Throwable $th) {
                ConsoleService::print(__METHOD__, 'red', $th);
                ConsoleService::newLine();
            }
            $converter->book->save();
        }

        return $converter->book;
    }

    /**
     * Generate Serie image from `public/storage/data/[model_name]s` if JPG file with `Author`|`Serie` `slug` exist.
     */
    public static function getLocal(Author|Serie $model): ?string
    {
        $class = new ReflectionClass($model::class);
        $class = $class->getShortName();
        $model_name = strtolower($class);
        $path = storage_path("app/public/data/{$model_name}s");
        $cover = null;

        $files = DirectoryParserService::parseDirectoryFiles($path);

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_FILENAME) === $model->slug) {
                $cover = base64_encode(file_get_contents($file));
            }
        }

        return $cover;
    }

    /**
     * Set local cover if exist.
     */
    public static function setLocalCover(Author|Serie $model): Serie|Author
    {
        $disk = MediaDiskEnum::cover;
        $local_cover = CoverConverter::getLocal($model);

        if ($model instanceof Serie) {
            SerieConverter::setBookCover($model);
        }

        if ($local_cover) {
            $model->clearMediaCollection($disk->value);
            MediaService::create($model, $model->slug, $disk)
                ->setMedia($local_cover)
                ->setColor()
            ;

            $model->save();
        }

        return $model;
    }
}
