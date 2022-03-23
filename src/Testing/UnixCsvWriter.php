<?php

namespace Bluesky\Testing;

use Bluesky\Testing\Interfaces\CsvWriter;

class UnixCsvWriter implements CsvWriter
{

    public function write(array $line): string
    {
        return join(',', $line) . '\n';
    }
}