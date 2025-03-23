<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Streamable;

use Generator;

/**
 * @template TKey
 * @template TValue
 * @extends StreamableIterator<TKey, TValue>
 */
class StreamableArray extends StreamableIterator
{
    /**
     * @param array<TKey, TValue> $data
     */
    public function __construct(array $data)
    {
        parent::__construct($this->generator($data));
    }

    /**
     * @param array<TKey, TValue> $data
     * @return Generator<mixed, mixed>
     */
    private function generator(array $data): Generator
    {
        foreach ($data as $key => $it) {
            yield $key => $it;
        }
    }
}
