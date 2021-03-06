<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;

/**
 * List of available formats.
 *
 * Check `ParserEngine::create()` if you want to add new format.
 *
 * ```php
 * $engine = match ($engine->format) {
 *   BookFormatEnum::epub => EpubModule::create($engine),
 *   default => false,
 * };
 * ```
 * For `download` link, the last value will be the first possibility.
 */
enum BookFormatEnum: string
{
    use EnumMethods;

    case pdf = 'pdf';
    case cbr = 'cbr';
    case cbz = 'cbz';
    case epub = 'epub';
}
