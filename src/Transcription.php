<?php

namespace Mostafamahmoud\Transcript;

class Transcription
{
    protected $file;
    public static function load(string $path)
    {
        $instance = new static();
        $instance->file = file_get_contents($path);
        return $instance;
    }

    public function __toString():string
    {
        return $this->file;
    }
}
