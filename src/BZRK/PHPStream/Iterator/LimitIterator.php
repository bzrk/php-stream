<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Iterator;

use BZRK\PHPStream\Streamable;
use Iterator;

/**
 * @template TKey
 * @template TValue
 * @extends \LimitIterator<TKey, TValue, Iterator<TKey, TValue>>
 * @implements Streamable<TKey, TValue>
 */
class LimitIterator extends \LimitIterator implements Streamable
{
}
