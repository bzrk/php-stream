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

    public static function of(array|Iterator|File|CsvFile $data): Stream
    {
        return new Stream(self::streamableOfType($data));
    }

    private static function streamableOfType(mixed $data): Streamable
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
        throw new InvalidArgumentException("type not found");
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
