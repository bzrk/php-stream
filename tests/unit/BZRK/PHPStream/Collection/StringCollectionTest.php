<?php

declare(strict_types=1);

namespace unit\BZRK\PHPStream\Collection;

use BZRK\PHPStream\Collection\StringCollection;
use BZRK\PHPStream\Stream;
use PHPUnit\Framework\TestCase;

class StringCollectionTest extends TestCase
{
    private StringCollection $collection;

    protected function setUp(): void
    {
        $this->collection = new StringCollection("a", "b");
        $this->collection->add("c");
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
        self::assertThat($data, self::equalTo(["a", "b", "c"]));
    }

    public function testStream(): void
    {
        self::assertThat($this->collection->stream(), self::isInstanceOf(Stream::class));
    }
}
