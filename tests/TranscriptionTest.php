<?php

namespace Tests;

use Mostafamahmoud\Transcript\Line;
use Mostafamahmoud\Transcript\Transcription;
use PHPUnit\Framework\TestCase;

class TranscriptionTest extends TestCase
{
    protected function setUp(): void
    {
        $this->transcation = Transcription::load(__DIR__ . '/stubs/basic-example.vtt');

    }
    public function test_it_loads_a_vtt_file()
    {
        $this->assertStringContainsString('Here is a', $this->transcation);
        $this->assertStringContainsString('example of a VTT file', $this->transcation);
        // Match Incoming Content Of File
    }
    public function test_it_can_convert_to_an_array_of_line_objects()
    {
        $lines = $this->transcation->lines();
        $this->assertCount(2, $lines);
        $this->assertContainsOnlyInstancesOf(Line::class, $lines);
    }

    public function test_it_discards_irrelevant_lines_from_the_vtt_file()
    {
        $this->assertStringNotContainsString('WEBVTT', $this->transcation);
        $this->assertCount(2, $this->transcation->lines());
    }

    public function test_it_renders_the_lines_as_html()
    {

        $expected = <<<EOT
        <a href="?time=00:03">Here is a</a>
        <a href="?time=00:04">example of a VTT file.</a>
        EOT;

        $this->assertEquals($expected, $this->transcation->htmlLines());

    }

}
