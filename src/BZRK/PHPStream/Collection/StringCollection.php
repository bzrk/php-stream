<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Collection;

use BZRK\PHPStream\Collection;

/**
 * @extends Collection<string>
 */
class StringCollection extends Collection
{
    public function __construct(string ...$data)
    {
        parent::__construct($data);
    }

    public function add(string $value): void
    {
        $this->addEntry($value);
    }

    public function current(): string
    {
        return $this->iterator->current();
    }
}
