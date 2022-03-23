<?php

namespace Bluesky\Testing\Interfaces;

interface JsonWriter
{
    public function write(array $lines, bool $formatted) : string;
}