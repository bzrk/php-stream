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
use InvalidArgumentException;
use Throwable;

use function implode;

class Stream
{
    /**
     * @var Streamable<mixed>
     */
    private Streamable $streamable;

    /**
     * @param Streamable<mixed> $streamable
     */
    public function __construct(Streamable $streamable)
    {
        $this->streamable = $streamable;
    }

    public function count(): int
    {
        return iterator_count($this->streamable);
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

    /**
     * @param bool $preserveKeys
     * @return array<mixed, mixed>
     */
    public function toList(bool $preserveKeys = false): array
    {
        return iterator_to_array($this->streamable, $preserveKeys);
    }

    /**
     * @param Closure $key
     * @param Closure $value
     * @return array<mixed, mixed>
     */
    public function toMap(Closure $key, Closure $value): array
    {
        $func = function () use ($key, $value): Generator {
            foreach ($this->streamable as $it) {
                yield $key($it) => $value($it);
            }
        };

        return iterator_to_array($func(), true);
    }

    /**
     * @param Closure $call
     * @return array<mixed, mixed>
     */
    public function associateBy(Closure $call): array
    {
        $func = function () use ($call): Generator {
            foreach ($this->streamable as $it) {
                yield $call($it) => $it;
            }
        };

        return iterator_to_array($func(), true);
    }

    /**
     * @return mixed|null
     */
    public function first()
    {
        foreach ($this->streamable as $it) {
            return $it;
        }
        return null;
    }

    /**
     * @throws StreamException
     */
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

    public function batch(int $count): self
    {
        /**
         * @throws StreamException
         */
        $func = function (int $count): Generator {
            $data = [];

            foreach ($this->streamable as $it) {
                $data[] = $it;
                if (count($data) >= $count) {
                    yield Streams::of($data);
                    $data = [];
                }
            }

            if (count($data) > 0) {
                yield Streams::of($data);
            }
        };

        return new Stream(new StreamableIterator($func($count)));
    }

    /**
     * @param string $class
     * @return Collection<mixed>
     * @throws StreamException
     */
    public function collect(string $class): Collection
    {
        if (!is_subclass_of($class, Collection::class)) {
            throw StreamException::createFromThrowable(
                new InvalidArgumentException('$class not from type ' . Collection::class)
            );
        }
        try {
            return new $class(...$this->toList());
        } catch (Throwable $throwable) {
            throw StreamException::createFromThrowable($throwable);
        }
    }

    /**
     * @param Closure|null $call
     * @param mixed $default
     * @return Generator
     */
    public function toGenerator(Closure $call = null, $default = null): Generator
    {
        $ret = null;
        $func = $call ?? fn() => null;
        foreach ($this->streamable as $it) {
            $ret = $func($it);
            yield $it;
        }
        return $ret ?? $default;
    }

    public function callBack(Closure $call): self
    {
        $func = function (Closure $call): Generator {
            foreach ($this->streamable as $it) {
                $call($it);
                yield $it;
            }
        };

        return new Stream(new StreamableIterator($func($call)));
    }
}
