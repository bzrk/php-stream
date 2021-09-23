<?php

declare(strict_types=1);

namespace BZRK\PHPStream;

class Comparator
{
    public function __construct(private \Closure $closure)
    {
    }

    public static function int(): Comparator
    {
        return new Comparator(fn(int $value1, int $value2) => $value1 - $value2);
    }

    public static function string(): Comparator
    {
        return new Comparator(fn(string $value1, $value2) => strcmp($value1, $value2));
    }

    final public function compare(mixed $value1, mixed $value2): int
    {
        $call = $this->closure;
        return $call($value1, $value2);
    }
}
