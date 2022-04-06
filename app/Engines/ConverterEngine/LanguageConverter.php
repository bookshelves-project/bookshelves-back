<?php

namespace App\Engines\ConverterEngine;

use App\Engines\ParserEngine;
use App\Models\Book;
use App\Models\Language;
use Locale;

class LanguageConverter
{
    /**
     * Set Language from ParserEngine.
     */
    public static function create(ParserEngine $parser, Book $book): Language
    {
        $lang_code = $parser->language;

        if (! $book->language) {
            $available_langs = config('bookshelves.langs');

            $language = Language::whereSlug($lang_code)->first();
            if (! $language) {
                $lang_names = [];
                foreach ($available_langs as $lang) {
                    $lang_names[$lang] = ucfirst(Locale::getDisplayLanguage($lang_code, $lang));
                }
                $language = Language::firstOrCreate([
                    'name' => $lang_names,
                    'slug' => $lang_code,
                ]);
            }

            $book->language()->associate($language);
            $book->save();

            return $language;
        }

        return $book->language;
    }
}
