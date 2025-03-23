<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Iterator;

use BZRK\PHPStream\Streamable;
use Closure;
use IteratorIterator;
use Traversable;

/**
 * @template TKey
 * @template TValue
 * @extends IteratorIterator<TKey, TValue, Traversable<TKey, TValue>>
 * @implements Streamable<TKey, TValue>
 */
class CallableIterator extends IteratorIterator implements Streamable
{
    private Closure $closure;

    /**
     * @param Streamable<TKey, TValue> $streamable
     * @param Closure $closure
     */
    public function __construct(Streamable $streamable, \Closure $closure)
    {
        parent::__construct($streamable);

        $this->closure = $closure;
    }

    #[\ReturnTypeWillChange]
    public function current()
    {
        $call = $this->closure;
        return $call(parent::current(), parent::key());
    }
}
