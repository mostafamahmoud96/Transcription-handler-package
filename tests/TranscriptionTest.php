<?php

namespace Tests;

use Mostafamahmoud\Transcript\Transcription;
use PHPUnit\Framework\TestCase;

class TranscriptionTest extends TestCase
{
    public function test_it_loads_a_vtt_file()
    {
        $transcription = Transcription::load(__DIR__ . '/stubs/basic-example.vtt');
        $expected = file_get_contents(__DIR__ . '/stubs/basic-example.vtt');
        $this->assertEquals($expected, $transcription);
    }

}
