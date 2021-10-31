<?php

declare(strict_types=1);

namespace unit\BZRK\PHPStream\Streamable;

use BZRK\PHPStream\Streamable;
use BZRK\PHPStream\Streamable\StreamableArray;
use PHPUnit\Framework\TestCase;

class StreamableArrayTest extends TestCase
{
    public function testIsAStreamable(): void
    {
        $streamable = new StreamableArray([]);
        $this->assertThat($streamable, $this->isInstanceOf(Streamable::class));
    }

    public function testCreate(): void
    {
        $streamable = new StreamableArray([1, 2, 3, 4]);
        $result = [];
        foreach ($streamable as $it) {
            $result[] = $it;
        }
        $this->assertThat($result, $this->equalTo([1, 2, 3, 4]));
    }
}
