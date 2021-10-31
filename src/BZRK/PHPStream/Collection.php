<?php

declare(strict_types=1);

namespace BZRK\PHPStream;

use ArrayIterator;
use Countable;
use Iterator;

class Collection implements Countable, Iterator
{
    private ArrayIterator $iterator;

    public function __construct(mixed ...$data)
    {
        $this->iterator = new ArrayIterator(...$data);
    }

    public function stream(): Stream
    {
        return Streams::of($this->iterator);
    }

    protected function addEntry(mixed $value)
    {
        $this->iterator->append($value);
    }

    public function count(): int
    {
        return $this->iterator->count();
    }

    public function current(): mixed
    {
        return $this->iterator->current();
    }

    public function next(): void
    {
        $this->iterator->next();
    }

    public function key(): float|bool|int|string|null
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
