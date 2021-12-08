<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Collection;

use BZRK\PHPStream\Collection;

class IntCollection extends Collection
{
    public function __construct(int ...$data)
    {
        parent::__construct($data);
    }

    public function add(int $value): void
    {
        $this->addEntry($value);
    }

    public function current(): int
    {
        return $this->iterator->current();
    }
}
