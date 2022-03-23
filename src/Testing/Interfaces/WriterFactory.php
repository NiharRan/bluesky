<?php

namespace Bluesky\Testing\Interfaces;

interface WriterFactory
{
    public function createJsonWriter() : JsonWriter;
    public function createCsvWriter() : CsvWriter;
}