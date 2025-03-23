<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Iterator;

use BZRK\PHPStream\Comparator;
use BZRK\PHPStream\Streamable;
use Generator;
use IteratorIterator;
use Traversable;

/**
 * @template TKey
 * @template TValue
 * @extends IteratorIterator<TKey, TValue, Traversable<TKey, TValue>>
 * @implements Streamable<TKey, TValue>
 */
class SortIterator extends IteratorIterator implements Streamable
{
    /**
     * @param Streamable<TKey, TValue> $streamable
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
     * @param Streamable<TKey, TValue> $streamable
     * @return array<TKey, TValue>
     */
    private function toArray(Streamable $streamable): array
    {
        return iterator_to_array($streamable);
    }
}
