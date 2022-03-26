<?php

namespace App\Engines\ParserEngine\Parsers;

use App\Engines\ParserEngine;

interface XmlInterface
{
    /**
     * Initialize `XmlParser`.
     *
     * Example from `OpfModule::class`
     * ```php
     * $xml = new XmlParser($parser, OpfModule::class, 'opf');
     * return $xml->openZip();
     * ```
     */
    public static function create(ParserEngine $engine): ParserEngine|false;

    /**
     * Parse XML `array` from `XmlParser`.
     *
     * Example from `CbzModule::class`
     * ```php
     * $module = new CbzModule();
     *
     * $module->xml_data = $xml->xml_data;
     * $module->engine = $xml->engine;
     *
     * $module->type = $module->xml_data['@root'];
     *
     * $is_supported = match ($module->type) {
     *      'ComicInfo' => $module->comicInfo(),
     *      default => false,
     * };
     *
     * if(! $is_supported) {
     *      return false;
     * }
     *
     * return $module->engine;
     * ```
     */
    public static function parse(XmlParser $xml): ParserEngine;
}