<?php

declare(strict_types=1);

namespace BZRK\PHPStream;

use Iterator;

/**
 * @template TKey
 * @template-covariant TValue
 * @extends Iterator<TKey, TValue>
 */
interface Streamable extends Iterator
{
}
