<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Iterator;

use BZRK\PHPStream\Streamable;
use CallbackFilterIterator;

class FilterIterator extends CallbackFilterIterator implements Streamable
{
}
