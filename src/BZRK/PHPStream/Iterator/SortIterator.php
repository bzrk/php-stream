<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Iterator;

use BZRK\PHPStream\Comparator;
use BZRK\PHPStream\Streamable;
use Generator;
use IteratorIterator;

/**
 * @extends IteratorIterator<mixed, mixed, \Iterator>
 */
class SortIterator extends IteratorIterator implements Streamable
{
    /**
     * @param Streamable<mixed> $streamable
     * @param Comparator $comparator
     */
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

    /**
     * @param Streamable<mixed> $streamable
     * @return array<mixed>
     */
    private function toArray(Streamable $streamable): array
    {
        return iterator_to_array($streamable);
    }
}
