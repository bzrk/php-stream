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
    /**
     * @param Streamable<mixed> $streamable
     * @param Closure $closure
     */
    public function __construct(Streamable $streamable, private Closure $closure)
    {
        parent::__construct($streamable);
    }

    /**
     * @return mixed
     */
    public function current(): mixed
    {
        $call = $this->closure;
        return $call(parent::current());
    }
}
