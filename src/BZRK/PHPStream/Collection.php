<?php

declare(strict_types=1);

namespace BZRK\PHPStream;

use ArrayIterator;
use Countable;
use Iterator;

/**
 * @template TValue
 * @implements Iterator<int|string, TValue>
 */
abstract class Collection implements Countable, Iterator
{
    /**
     * @var ArrayIterator<int|string, TValue>
     */
    protected ArrayIterator $iterator;

    /**
     * @param array<int|string, TValue> $data
     */
    protected function __construct(array $data)
    {
        $this->iterator = new ArrayIterator($data);
    }

    /**
     * @return Stream<int|string, TValue>
     */
    public function stream(): Stream
    {
        return Streams::of($this->iterator);
    }

    /**
     * @param mixed $value
     */
    protected function addEntry(mixed $value): void
    {
        $this->iterator->append($value);
    }

    public function count(): int
    {
        return $this->iterator->count();
    }

    public function next(): void
    {
        $this->iterator->next();
    }

    /**
     * @return mixed
     */
    public function key(): mixed
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
