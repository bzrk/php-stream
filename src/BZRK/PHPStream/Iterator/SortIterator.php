<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Iterator;

use BZRK\PHPStream\Comparator;
use BZRK\PHPStream\Streamable;
use Generator;

class SortIterator extends \IteratorIterator implements Streamable
{
    public function __construct(Streamable $streamable, Comparator $comparator)
    {
        $data = $this->toArray($streamable);
        usort($data, fn($a, $b) => $comparator->compare($a, $b));
        $fn = function () use ($data): Generator {
            foreach ($data as $it) {
                yield $it;
            }
        };
        parent::__construct($fn());
    }

    private function toArray(Streamable $streamable): array
    {
        $data = [];
        foreach ($streamable as $it) {
            $data[] = $it;
        }
        return $data;
    }
}
