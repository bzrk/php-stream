<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Streamable;

use BZRK\PHPStream\Streamable;

class StreamableIterator implements Streamable
{
    public function __construct(private \Iterator $iterator)
    {
    }

    public function current()
    {
        return $this->iterator->current();
    }

    public function next()
    {
        $this->iterator->next();
    }

    public function key()
    {
        return $this->iterator->key();
    }

    public function valid()
    {
        return $this->iterator->valid();
    }

    public function rewind()
    {
        $this->iterator->rewind();
    }
}
