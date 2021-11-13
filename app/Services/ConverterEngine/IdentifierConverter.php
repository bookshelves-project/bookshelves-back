<?php

namespace App\Services\ConverterEngine;

use App\Models\Book;
use App\Models\Identifier;
use App\Services\ParserEngine\Models\OpfIdentifier;
use App\Services\ParserEngine\ParserEngine;

class IdentifierConverter
{
    public static function create(ParserEngine $parser, Book $book): ?Identifier
    {
        $identifier = null;
        $identifiers = [];

        /** @var OpfIdentifier $value */
        foreach ($parser->identifiers as $key => $value) {
            if ('isbn' === $value->name) {
                $identifiers['isbn'] = $value->value;
            }
            if ('isbn13' === $value->name) {
                $identifiers['isbn13'] = $value->value;
            }
            if ('doi' === $value->name) {
                $identifiers['doi'] = $value->value;
            }
            if ('amazon' === $value->name) {
                $identifiers['amazon'] = $value->value;
            }
            if ('google' === $value->name) {
                $identifiers['google'] = $value->value;
            }
        }
        if (! empty($identifiers)) {
            $identifier = Identifier::firstOrCreate($identifiers);
            $book->identifier()->associate($identifier);
            $book->save();
        }

        return $identifier;
    }
}
