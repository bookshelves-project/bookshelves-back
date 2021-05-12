<?php

namespace App\Utils;

use App\Models\Book;
use App\Models\Serie;
use App\Models\Author;
use Illuminate\Support\Str;
use App\Http\Resources\Search\SearchBookResource;
use App\Http\Resources\Search\SearchSerieResource;
use App\Http\Resources\Search\SearchAuthorResource;

class BookshelvesTools
{
    public static function searchGlobal(string $searchTermRaw)
    {
        $searchTerm = mb_convert_encoding($searchTermRaw, 'UTF-8', 'UTF-8');
        $authors = Author::whereLike(['name', 'firstname', 'lastname'], $searchTerm)->get();
        $series = Serie::whereLike(['title', 'authors.name'], $searchTerm)->get();
        $books = Book::whereLike(['title', 'authors.name', 'serie.title'], $searchTerm)->orderBy('serie_id')->orderBy('volume')->get();

        // $authors = SearchAuthorResource::collection($authors);
        $authors = collect([]);
        $series = SearchSerieResource::collection($series);
        $books = SearchBookResource::collection($books);
        $collection = $authors->merge($series);
        $collection = $collection->merge($books);

        return $collection->all();
    }

    /**
     * DISCONTINUED
     * Remove accents from string.
     *
     * @param mixed $stripAccents
     *
     * @return string
     */
    public static function stripAccents($stripAccents): string
    {
        return strtr(
            utf8_decode($stripAccents),
            utf8_decode(
                'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'),
                'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'
            );
    }

    /**
     * Convert bytes to human readable filesize.
     *
     * @param string|int $bytes
     * @param int|null   $decimals
     *
     * @return string
     */
    public static function humanFilesize(string | int $bytes, ?int $decimals = 2): string
    {
        $sz = [
            'B',
            'Ko',
            'Mo',
            'Go',
            'To',
            'Po',
        ];
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)).' '.@$sz[$factor];
    }

    /**
     * Limit length of a string and sanitize.
     *
     * @param string $text
     * @param int    $limit
     *
     * @return string
     */
    public static function stringLimit(string $text, int $limit): string
    {
        $isUTF8 = mb_check_encoding($text, 'UTF-8');
        $content = iconv('UTF-8', 'UTF-8//IGNORE', $text);

        if ($isUTF8) {
            $content = trim($content);
            if ($limit && strlen($content) > $limit) {
                $content = substr($content, 0, $limit).'...';
            }
            $content = strip_tags($content);
            $content = Str::ascii($content);
            $content = str_replace('<<', '"', $content);
            $content = str_replace('>>', '"', $content);
            $content = trim($content);
        }

        return $content;

        // $content = substr($text, 0, $limit);
        // $content = trim($content);
        // $content = $content.'...';
        // $content = self::hyphenize($content);

        // return $content;
    }

    /**
     * Sanitize string.
     *
     * @param string $string
     *
     * @return string
     */
    public static function hyphenize(string $string): string
    {
        $dict = [
            "I'm"      => 'I am',
            // Add your own replacements here
        ];

        return strtolower(
            preg_replace(
              ['#[\\s-]+#', '#[^A-Za-z0-9. -]+#'],
              ['-', ''],
              // the full cleanString() can be downloaded from http://www.unexpectedit.com/php/php-clean-string-of-utf8-chars-convert-to-similar-ascii-char
              self::cleanString(
                  str_replace( // preg_replace can be used to support more complicated replacements
                      array_keys($dict),
                      array_values($dict),
                      urldecode($string)
                  )
              )
            )
        );
    }

    /**
     * Clean accents and special characters of string.
     *
     * @param string $text
     *
     * @return string
     */
    public static function cleanString(string $text): string
    {
        $utf8 = [
            '/[áàâãªä]/u'   => 'a',
            '/[ÁÀÂÃÄ]/u'    => 'A',
            '/[ÍÌÎÏ]/u'     => 'I',
            '/[íìîï]/u'     => 'i',
            '/[éèêë]/u'     => 'e',
            '/[ÉÈÊË]/u'     => 'E',
            '/[óòôõºö]/u'   => 'o',
            '/[ÓÒÔÕÖ]/u'    => 'O',
            '/[úùûü]/u'     => 'u',
            '/[ÚÙÛÜ]/u'     => 'U',
            '/ç/'           => 'c',
            '/Ç/'           => 'C',
            '/ñ/'           => 'n',
            '/Ñ/'           => 'N',
            '/–/'           => '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u'    => ' ', // Literally a single quote
            '/[“”«»„]/u'    => ' ', // Double quote
            '/ /'           => ' ', // nonbreaking space (equiv. to 0x160)
        ];

        $string = preg_replace(array_keys($utf8), array_values($utf8), $text);

        return $string ? $string : '';
    }
}
