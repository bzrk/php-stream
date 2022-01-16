<?php

declare(strict_types=1);

namespace BZRK\PHPStream;

use SplFileObject;

class CsvFile extends SplFileObject
{
    private string $separator = ",";
    private string $enclosure = "\"";
    private string $escape = "\\";

    public function __construct(
        string $path,
        string $separator = ",",
        string $enclosure = "\"",
        string $escape = "\\"
    ) {
        parent::__construct($path);

        $this->separator = $separator;
        $this->enclosure = $enclosure;
        $this->escape = $escape;
    }

    /**
     * @return string
     */
    public function separator(): string
    {
        return $this->separator;
    }

    /**
     * @return string
     */
    public function enclosure(): string
    {
        return $this->enclosure;
    }

    /**
     * @return string
     */
    public function escape(): string
    {
        return $this->escape;
    }
}
