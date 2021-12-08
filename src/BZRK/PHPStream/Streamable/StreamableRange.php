<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Streamable;

use Generator;

class StreamableRange extends StreamableIterator
{
    public function __construct(int $start, int $end)
    {
        parent::__construct($this->generator($start, $end));
    }

    /**
     * @param int $start
     * @param int $end
     * @return Generator<int>
     */
    private function generator(int $start, int $end): Generator
    {
        for ($it = $start; $it <= $end; $it++) {
            yield $it;
        }
    }
}
