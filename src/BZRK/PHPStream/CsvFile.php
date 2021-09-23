<?php

declare(strict_types=1);

namespace BZRK\PHPStream;

class CsvFile extends \SplFileObject
{
    public function __construct(
        string $path,
        private string $separator = ",",
        private string $enclosure = "\"",
        private string $escape = "\\"
    ) {
        parent::__construct($path);
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
