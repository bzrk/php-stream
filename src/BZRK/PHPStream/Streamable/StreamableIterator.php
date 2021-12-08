<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Streamable;

use BZRK\PHPStream\Streamable;
use Iterator;

class StreamableIterator implements Streamable
{
    /**
     * @param Iterator<mixed> $iterator
     */
    public function __construct(private Iterator $iterator)
    {
    }

    /**
     * @return mixed
     */
    public function current(): mixed
    {
        return $this->iterator->current();
    }

    public function next(): void
    {
        $this->iterator->next();
    }

    public function key(): string|int|bool|null|float
    {
        return $this->iterator->key();
    }

    public function valid(): bool
    {
        return $this->iterator->valid();
    }

    public function rewind(): void
    {
        $this->iterator->rewind();
    }
}
