<?php

namespace Bluesky\Testing;

use Bluesky\Testing\Interfaces\JsonWriter;

class WinJsonWriter implements JsonWriter
{
    public function write(array $lines, bool $formatted): string
    {
        return json_encode($lines, JSON_PRETTY_PRINT);
    }
}