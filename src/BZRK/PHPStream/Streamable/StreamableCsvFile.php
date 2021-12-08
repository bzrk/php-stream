<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Streamable;

use BZRK\PHPStream\CsvFile;
use Generator;

class StreamableCsvFile extends StreamableIterator
{
    public function __construct(CsvFile $file)
    {
        parent::__construct($this->generator($file));
    }

    /**
     * @param CsvFile $file
     * @return Generator<array<string>>
     */
    private function generator(CsvFile $file): Generator
    {
        while (!$file->eof()) {
            yield $file->fgetcsv($file->separator(), $file->enclosure(), $file->escape());
        }
    }
}
