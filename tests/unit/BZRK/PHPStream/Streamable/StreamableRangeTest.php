<?php

declare(strict_types=1);

namespace unit\BZRK\PHPStream\Streamable;

use BZRK\PHPStream\Streamable;
use BZRK\PHPStream\Streamable\StreamableRange;
use PHPUnit\Framework\TestCase;

class StreamableRangeTest extends TestCase
{
    public function testIsAStreamable(): void
    {
        $streamable = new StreamableRange(0, 1);
        $this->assertThat($streamable, $this->isInstanceOf(Streamable::class));
    }

    public function testCreate(): void
    {
        $streamable = new StreamableRange(1, 5);
        $result = [];
        foreach ($streamable as $it) {
            $result[] = $it;
        }
        $this->assertThat($result, $this->equalTo([1, 2, 3, 4, 5]));
    }
}
