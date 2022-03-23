<?php

namespace Bluesky\Testing;

use Bluesky\Testing\Interfaces\JsonWriter;

class UnixJsonWriter implements JsonWriter
{
    public function write(array $lines, bool $formatted): string
    {
        $options = 0;
        if ($formatted) {
            $options = JSON_PRETTY_PRINT;
        }

        return json_encode($lines, $options);
    }
}