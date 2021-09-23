<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Streamable;

use Generator;

class StreamableArray extends StreamableIterator
{
    public function __construct(array $data)
    {
        parent::__construct($this->generator($data));
    }

    private function generator(array $data): Generator
    {
        foreach ($data as $it) {
            yield $it;
        }
    }
}
