<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Streamable;

use BZRK\PHPStream\Streamable;

class StreamableIterator implements Streamable
{
    public function __construct(private \Generator $generator)
    {
    }

    public function current()
    {
        return $this->generator->current();
    }

    public function next()
    {
        $this->generator->next();
    }

    public function key()
    {
        return $this->generator->key();
    }

    public function valid()
    {
        return $this->generator->valid();
    }

    public function rewind()
    {
        $this->generator->rewind();
    }
}
