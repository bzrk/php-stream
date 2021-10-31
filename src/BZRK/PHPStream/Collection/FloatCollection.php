<?php

declare(strict_types=1);

namespace BZRK\PHPStream\Collection;

use BZRK\PHPStream\Collection;

class IntFloatCollection extends Collection
{
    public function __construct(float $data)
    {
        parent::__construct($data);
    }

    public function add(float $value): void
    {
        $this->addEntry($value);
    }
}
