<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Streamable;

use Generator;

class StreamableArray extends StreamableIterator
{
    /**
     * @param array<mixed> $data
     */
    public function __construct(array $data)
    {
        parent::__construct($this->generator($data));
    }

    /**
     * @param array<mixed> $data
     * @return Generator<mixed, mixed>
     */
    private function generator(array $data): Generator
    {
        foreach ($data as $key => $it) {
            yield $key => $it;
        }
    }
}
