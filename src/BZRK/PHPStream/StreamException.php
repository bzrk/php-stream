<?php

declare(strict_types=1);

namespace BZRK\PHPStream;

use Exception;
use Throwable;

class StreamException extends Exception
{
    public function __construct(string $msg, ?Throwable $throwable = null)
    {
        parent::__construct($msg, 0, $throwable);
    }

    public static function create(string $msg, ?Throwable $throwable = null): self
    {
        return new StreamException($msg, $throwable);
    }

    public static function createFromThrowable(Throwable $throwable): self
    {
        return new StreamException($throwable->getMessage(), $throwable);
    }
}
