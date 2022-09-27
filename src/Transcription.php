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
        $lines = [];
        for ($i = 0; $i < count($this->lines); $i += 2) {
            $results[] = new Line($this->lines[$i], $this->lines[$i + 1]);
        }
        return $results;
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
