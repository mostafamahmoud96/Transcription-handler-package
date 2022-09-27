<?php

namespace Tests;

use Mostafamahmoud\Transcript\Line;
use Mostafamahmoud\Transcript\Transcription;
use PHPUnit\Framework\TestCase;

class TranscriptionTest extends TestCase
{
    public function test_it_loads_a_vtt_file()
    {
        $file = __DIR__ . '/stubs/basic-example.vtt';
        $transcription = Transcription::load($file);
        $this->assertStringContainsString('Here is a', $transcription);
        $this->assertStringContainsString('example of a VTT file', $transcription);
        // Match Incoming Content Of File
    }
    public function test_it_can_convert_to_an_array_of_line_objects()
    {
        $file = __DIR__ . '/stubs/basic-example.vtt';
        $lines = Transcription::load($file)->lines();
        $this->assertCount(2, $lines);
        $this->assertContainsOnlyInstancesOf(Line::class, $lines);
    }

    public function test_it_discards_irrelevant_lines_from_the_vtt_file()
    {
        $transcription = Transcription::load(__DIR__ . '/stubs/basic-example.vtt');
        $this->assertStringNotContainsString('WEBVTT', $transcription);
        $this->assertCount(2, $transcription->lines());
    }

    public function test_it_renders_the_lines_as_html()
    {
        $transcription = Transcription::load(__DIR__ . '/stubs/basic-example.vtt');

        $expected = <<<EOT
        <a href="?time=00:03">Here is a</a>
        <a href="?time=00:04">example of a VTT file.</a>
        EOT;

        $this->assertEquals($expected, $transcription->htmlLines());

    }

}
