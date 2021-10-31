<?php

declare(strict_types=1);

namespace unit\BZRK\PHPStream\Collection;

use BZRK\PHPStream\Collection\IntCollection;
use BZRK\PHPStream\Stream;
use PHPUnit\Framework\TestCase;

class IntCollectionTest extends TestCase
{
    private IntCollection $collection;

    protected function setUp(): void
    {
        $this->collection = new IntCollection(1, 2);
        $this->collection->add(3);
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
        self::assertThat($data, self::equalTo([1, 2, 3]));
    }

    public function testStream(): void
    {
        self::assertThat($this->collection->stream(), self::isInstanceOf(Stream::class));
    }
}
