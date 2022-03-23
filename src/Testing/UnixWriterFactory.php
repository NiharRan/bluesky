<?php

namespace Bluesky\Testing;

use Bluesky\Testing\Interfaces\CsvWriter;
use Bluesky\Testing\Interfaces\JsonWriter;
use Bluesky\Testing\Interfaces\WriterFactory;

class UnixWriterFactory implements WriterFactory
{

    public function createJsonWriter(): JsonWriter
    {
        return new UnixJsonWriter();
    }

    public function createCsvWriter(): CsvWriter
    {
        return new UnixCsvWriter();
    }
}