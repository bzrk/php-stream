<?php

declare(strict_types=1);

namespace unit\BZRK\PHPStream\Collection;

use BZRK\PHPStream\Collection\FloatCollection;
use BZRK\PHPStream\Stream;
use PHPUnit\Framework\TestCase;

class FloatCollectionTest extends TestCase
{
    private FloatCollection $collection;

    protected function setUp(): void
    {
        $this->collection = new FloatCollection(1.2, 2.3);
        $this->collection->add(3.4);
    }


    public function testCount(): void
    {
        self::assertThat($this->collection->count(), self::equalTo(3));
    }

    public function testIterate(): void
    {
        $data = [];
        foreach ($this->collection as $entry) {
            $data[] = $entry;
        }
        self::assertThat($data, self::equalTo([1.2, 2.3, 3.4]));
    }

    public function testStream(): void
    {
        self::assertThat($this->collection->stream(), self::isInstanceOf(Stream::class));
    }
}
