<?php

declare(strict_types=1);

namespace BZRK\PHPStream;

use BZRK\PHPStream\Iterator\CallableIterator;
use BZRK\PHPStream\Iterator\FilterIterator;
use BZRK\PHPStream\Iterator\LimitIterator;
use BZRK\PHPStream\Iterator\SortIterator;
use BZRK\PHPStream\Streamable\StreamableIterator;
use Closure;
use Generator;

use function implode;

class Stream
{
    private Streamable $streamable;

    public function __construct(Streamable $streamable)
    {
        $this->streamable = $streamable;
    }

    public function count(): int
    {
        $count = 0;
        $this->each(function () use (&$count): void {
            $count++;
        });
        return $count;
    }

    public function map(Closure $call): self
    {
        return new Stream(new CallableIterator($this->streamable, $call));
    }

    public function flatMap(Closure $call): self
    {
        $func = function (Closure $call): Generator {
            foreach ($this->streamable as $it) {
                foreach ($it as $subIt) {
                    yield $call($subIt);
                }
            }
        };

        return new Stream(new StreamableIterator($func($call)));
    }

    public function filter(Closure $call): self
    {
        return new Stream(new FilterIterator($this->streamable, $call));
    }

    public function notNull(): self
    {
        return new Stream(new FilterIterator($this->streamable, fn($it) => $it !== null));
    }

    public function notEmpty(): self
    {
        return new Stream(new FilterIterator($this->streamable, fn($it) => !empty($it)));
    }

    public function each(Closure $call): void
    {
        foreach ($this->streamable as $key => $value) {
            $call($value, $key);
        }
    }

    public function toList(bool $keepKeys = false): array
    {
        $data = [];
        $this->each(function ($it, $key) use (&$data, $keepKeys): void {
            if (!$keepKeys) {
                $data[] = $it;
            } else {
                $data[$key] = $it;
            }
        });
        return $data;
    }

    public function toMap(Closure $key, Closure $value): array
    {
        $data = [];
        $this->each(function ($it) use (&$data, $key, $value): void {
            $data[$key($it)] = $value($it);
        });
        return $data;
    }

    public function first(): mixed
    {
        foreach ($this->streamable as $it) {
            return $it;
        }
        return null;
    }

    public function run(): self
    {
        return Streams::of($this->toList(true));
    }

    public function limit(int $size): self
    {
        return new Stream(new LimitIterator($this->streamable, 0, $size));
    }

    public function order(Comparator $comparator): self
    {
        return new Stream(new SortIterator($this->streamable, $comparator));
    }

    public function skip(int $count): self
    {
        return new Stream(new LimitIterator($this->streamable, $count));
    }

    public function implode(string $separator = ','): string
    {
        return implode($separator, $this->toList());
    }
}
