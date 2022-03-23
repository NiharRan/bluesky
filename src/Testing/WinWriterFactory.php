<?php

namespace Bluesky\Testing;

use Bluesky\Testing\Interfaces\CsvWriter;
use Bluesky\Testing\Interfaces\JsonWriter;
use Bluesky\Testing\Interfaces\WriterFactory;

class WinWriterFactory implements WriterFactory
{

    public function createJsonWriter(): JsonWriter
    {
        return new WinJsonWriter();
    }

    /**
     * @return CsvWriter
     */
    public function createCsvWriter(): CsvWriter
    {
        return new WinCsvWriter();
    }
}