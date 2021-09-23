<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Iterator;

use BZRK\PHPStream\Streamable;
use IteratorIterator;

class CallableIterator extends IteratorIterator implements Streamable
{
    public function __construct(Streamable $streamable, private \Closure $closure)
    {
        parent::__construct($streamable);
    }

    public function current()
    {
        $call = $this->closure;
        return $call(parent::current());
    }
}
