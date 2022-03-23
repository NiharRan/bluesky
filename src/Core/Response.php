<?php

namespace Bluesky\Core;

class Response
{
    use StatusCode;
    private string $status;
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    public function json(array|string|object $data)
    {
        return json_encode($data, JSON_PRETTY_PRINT);
    }
}