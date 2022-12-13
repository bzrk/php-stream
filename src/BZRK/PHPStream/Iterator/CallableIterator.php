<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Iterator;

use BZRK\PHPStream\Streamable;
use Closure;
use IteratorIterator;

/**
 * @extends IteratorIterator<mixed, mixed, \Iterator>
 */
class CallableIterator extends IteratorIterator implements Streamable
{
    private Closure $closure;

    /**
     * @param Streamable<mixed> $streamable
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
