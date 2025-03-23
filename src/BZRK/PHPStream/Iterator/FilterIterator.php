<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Iterator;

use BZRK\PHPStream\Streamable;
use CallbackFilterIterator;
use Traversable;

/**
 * @template TKey
 * @template TValue
 * @extends CallbackFilterIterator<TKey, TValue, Traversable<TKey, TValue>>
 * @implements Streamable<TKey, TValue>
 */
class FilterIterator extends CallbackFilterIterator implements Streamable
{
}
