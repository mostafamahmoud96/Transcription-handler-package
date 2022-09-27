<?php

namespace Mostafamahmoud\Transcript;

class Transcription
{

    public function __construct(protected array $lines)
    {
        $this->lines = $this->discardIrrelevantLines(array_map('trim', $lines));
    }

    public static function load(string $path): self
    {
        return new static(file($path));
    }
    public function lines(): array
    {
        return array_map(function ($line) {
            return new Line($line[0], $line[1]);
        }, array_chunk($this->lines, 2));
    }
    public function htmlLines()
    {
        return implode("\n", array_map(
            fn(Line $line) => $line->toAnchorTag(),
            $this->lines()
        ));
    }

    protected function discardIrrelevantLines(array $lines): array
    {
        return array_values(array_filter(
            $lines,
            fn($line) => Line::valid($line)
        ));
    }

    public function __toString(): string
    {
        return implode("\n", $this->lines);
    }
}
