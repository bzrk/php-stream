<?php

declare(strict_types=1);

namespace BZRK\PHPStream;

use BZRK\PHPStream\Streamable\StreamableArray;
use BZRK\PHPStream\Streamable\StreamableCsvFile;
use BZRK\PHPStream\Streamable\StreamableFile;
use BZRK\PHPStream\Streamable\StreamableIterator;
use BZRK\PHPStream\Streamable\StreamableRange;
use InvalidArgumentException;
use Iterator;

/**
 * @template TKey
 * @template TValue
 */
class Streams
{
    private function __construct()
    {
    }

    /**
     * @param Iterator<TKey, TValue>|CsvFile|File|array<TKey, TValue> $data
     * @return Stream<TKey, TValue>
     */
    public static function of(File|Iterator|array|CsvFile $data): Stream
    {
        return new Stream(self::streamableOfType($data));
    }

    /**
     * @param Iterator<TKey, TValue>|CsvFile|File|array<TKey, TValue> $data
     * @return Streamable<TKey, TValue>
     */
    private static function streamableOfType(File|Iterator|array|CsvFile $data): Streamable
    {
        return match (true) {
            is_array($data) => new StreamableArray($data),
            $data instanceof File => new StreamableFile($data),
            $data instanceof CsvFile => new StreamableCsvFile($data),
            default => new StreamableIterator($data),
        };
    }

    /**
     * @param int $start
     * @param int $inclusiveEnd
     * @return Stream<int, int>
     */
    public static function range(int $start, int $inclusiveEnd): Stream
    {
        return new Stream(new StreamableRange($start, $inclusiveEnd));
    }

    /**
     * @param string $pattern
     * @param string $source
     * @return Stream<TKey, TValue>
     * @throws StreamException
     */
    public static function split(string $pattern, string $source): Stream
    {
        $data = preg_split($pattern, $source);
        if (is_array($data)) {
            return Streams::of($data);
        }
        return Streams::of([]);
    }
}
