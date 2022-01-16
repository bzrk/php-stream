<?php

declare(strict_types=1);

namespace BZRK\PHPStream;

class Comparator
{
    private \Closure $closure;

    public function __construct(\Closure $closure)
    {
        $this->closure = $closure;
    }

    public static function int(): Comparator
    {
        return new Comparator(fn(int $value1, int $value2) => $value1 - $value2);
    }

    public static function string(): Comparator
    {
        return new Comparator(fn(string $value1, $value2) => strcmp($value1, $value2));
    }

    /**
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return int
     */
    final public function compare($value1, $value2): int
    {
        $call = $this->closure;
        return $call($value1, $value2);
    }
}
