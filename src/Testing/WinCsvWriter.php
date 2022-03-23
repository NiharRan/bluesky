<?php

namespace Bluesky\Testing;

use Bluesky\Testing\Interfaces\CsvWriter;

class WinCsvWriter implements CsvWriter
{
    public function write(array $line): string
    {
        return join(',', $line) . '\r\n';
    }
}