<?php

declare(strict_types=1);

namespace unit\BZRK\PHPStream;

use ArrayIterator;
use BZRK\PHPStream\CsvFile;
use BZRK\PHPStream\File;
use BZRK\PHPStream\Stream;
use BZRK\PHPStream\Streams;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertThat;

class StreamsTest extends TestCase
{
    /**
     * @param mixed $type
     *
     * @dataProvider dataProviderTestOf
     */
    public function testOf(mixed $type): void
    {
        assertThat(Streams::of($type), self::isInstanceOf(Stream::class));
    }

    /**
     * @return array<mixed>
     */
    public function dataProviderTestOf(): array
    {
        return [
            [[]],
            [new File(__FILE__)],
            [new CsvFile(__FILE__)],
            [new ArrayIterator([])]
        ];
    }

    public function testRange(): void
    {
        assertThat(Streams::split("/[;,]/", "1,2"), self::isInstanceOf(Stream::class));
    }

    public function testSplit(): void
    {
        assertThat(Streams::range(1, 3), self::isInstanceOf(Stream::class));
    }
}
