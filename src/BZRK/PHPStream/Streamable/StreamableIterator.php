<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Streamable;

use BZRK\PHPStream\Streamable;
use Iterator;

class StreamableIterator implements Streamable
{
    /**
     * @var Iterator<mixed> $iterator
     */
    private Iterator $iterator;

    /**
     * @param Iterator<mixed> $iterator
     */
    public function __construct(Iterator $iterator)
    {
        $this->iterator = $iterator;
    }

    #[\ReturnTypeWillChange]
    public function current()
    {
        return $this->iterator->current();
    }

    public function next(): void
    {
        $this->iterator->next();
    }

    #[\ReturnTypeWillChange]
    public function key()
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
