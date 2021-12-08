<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Streamable;

use BZRK\PHPStream\File;
use Generator;

class StreamableFile extends StreamableIterator
{
    public function __construct(File $file)
    {
        parent::__construct($this->generator($file));
    }

    /**
     * @param File $file
     * @return Generator<string>
     */
    private function generator(File $file): Generator
    {
        while (!$file->eof()) {
            yield trim($file->fgets());
        }
    }
}
