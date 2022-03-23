<?php

namespace Bluesky\Testing\Interfaces;

interface CsvWriter
{
    public function write(array $line) : string;
}