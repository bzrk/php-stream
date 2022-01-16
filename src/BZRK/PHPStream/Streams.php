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

class Streams
{
    private function __construct()
    {
    }

    /**
     * @param array<mixed>|Iterator<mixed>|File|CsvFile $data
     * @return Stream
     * @throws StreamException
     */
    public static function of($data): Stream
    {
        return new Stream(self::streamableOfType($data));
    }

    /**
     * @param array<mixed>|Iterator<mixed>|File|CsvFile $data
     * @return Streamable<mixed>
     * @throws StreamException
     */
    private static function streamableOfType($data): Streamable
    {
        switch (true) {
            case is_array($data):
                return new StreamableArray($data);
            case $data instanceof File:
                return new StreamableFile($data);
            case $data instanceof CsvFile:
                return new StreamableCsvFile($data);
            case $data instanceof Iterator:
                return new StreamableIterator($data);
        }
        throw StreamException::createFromThrowable(new InvalidArgumentException("type not found"));
    }

    public static function range(int $start, int $inclusiveEnd): Stream
    {
        return new Stream(new StreamableRange($start, $inclusiveEnd));
    }

    public static function split(string $pattern, string $source): Stream
    {
        $data = preg_split($pattern, $source);
        if (is_array($data)) {
            return Streams::of($data);
        }
        return Streams::of([]);
    }
}
