<?php

declare(strict_types=1);

namespace unit\BZRK\PHPStream;

use ArrayIterator;
use BZRK\PHPStream\CsvFile;
use BZRK\PHPStream\File;
use BZRK\PHPStream\Stream;
use BZRK\PHPStream\StreamException;
use BZRK\PHPStream\Streams;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertThat;

class StreamsTest extends TestCase
{
    /**
     * @throws StreamException
     */
    #[Test]
    #[DataProvider('dataProviderTestOf')]
    public function testOf(mixed $type): void
    {
        assertThat(Streams::of($type), self::isInstanceOf(Stream::class));
    }

    public static function dataProviderTestOf(): Generator
    {
        yield [[]];
        yield [new File(__FILE__)];
        yield [new CsvFile(__FILE__)];
        yield [new ArrayIterator([])];
    }

    #[Test]
    public function createByWrongType(): void
    {
        $this->expectException(StreamException::class);
        $this->expectExceptionMessage("type not found");

        // @phpstan-ignore-next-line
        Streams::of(1);
    }

    #[Test]
    public function createBySplittingAString(): void
    {
        assertThat(Streams::split("/[;,]/", "1,2"), self::isInstanceOf(Stream::class));
    }

    #[Test]
    public function createStreamFromRange(): void
    {
        assertThat(Streams::range(1, 3), self::isInstanceOf(Stream::class));
    }
}
