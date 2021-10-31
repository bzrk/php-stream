<?php

declare(strict_types=1);

namespace unit\BZRK\PHPStream\Streamable;

use BZRK\PHPStream\CsvFile;
use BZRK\PHPStream\Streamable;
use BZRK\PHPStream\Streamable\StreamableCsvFile;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;
use PHPUnit\Framework\TestCase;

class StreamableCsvFileTest extends TestCase
{
    public function testIsAStreamable(): void
    {
        $streamable = new StreamableCsvFile(new CsvFile(__FILE__, ";"));
        self::assertThat($streamable, $this->isInstanceOf(Streamable::class));
    }

    public function testCreate(): void
    {
        $root = vfsStream::setup('csv');
        $file = new vfsStreamFile("data.csv");
        $file->setContent(
            "1;2;4\n7;8;5\n"
        );
        $root->addChild($file);

        $streamable = new StreamableCsvFile(new CsvFile(vfsStream::url('csv/data.csv'), ";"));
        $result = [];
        foreach ($streamable as $it) {
            $result[] = $it;
        }
        self::assertThat($result, self::equalTo([[1, 2, 4], [7, 8, 5]]));
    }
}
