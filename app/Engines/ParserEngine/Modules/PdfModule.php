<?php

namespace App\Engines\ParserEngine\Modules;

use App\Engines\ParserEngine;
use App\Engines\ParserEngine\Parsers\NameParser;
use App\Services\ConsoleService;
use File;
use Imagick;

class PdfModule
{
    public static function create(ParserEngine $parser): ParserEngine|false
    {
        if (! extension_loaded('Imagick')) {
            ConsoleService::print('.pdf file: Imagick extension: is not installed', 'red');
        } else {
            $format = 'jpg';

            $imagick = new Imagick($parser->file_path.'[0]');
            $imagick->setFormat($format);

            $name = $parser->file_name;
            $path = public_path("storage/cache/{$name}.jpg");
            $imagick->writeImage($path);

            // $image = new Imagick();
            // $image->setResolution(300, 300);
            // $image->readImage($parser->file_path);
            // $image->setImageFormat('webp');
            // $image->scaleImage(500, 500, true);
            // $image->setImageAlphaChannel(Imagick::VIRTUALPIXELMETHOD_WHITE);
            $parser->cover_file = base64_encode(File::get($path));
            $imagick->clear();
            $imagick->destroy();
        }

        return NameParser::parse($parser);
    }
}
