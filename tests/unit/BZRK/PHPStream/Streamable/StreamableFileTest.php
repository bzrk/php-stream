<?php

declare(strict_types=1);

namespace unit\BZRK\PHPStream\Streamable;

use BZRK\PHPStream\File;
use BZRK\PHPStream\Streamable;
use BZRK\PHPStream\Streamable\StreamableFile;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;
use PHPUnit\Framework\TestCase;

class StreamableFileTest extends TestCase
{
    public function testIsAStreamable(): void
    {
        $streamable = new StreamableFile(new File(__FILE__));
        self::assertThat($streamable, $this->isInstanceOf(Streamable::class));
    }

    public function testCreate(): void
    {
        $root = vfsStream::setup('data');
        $file = new vfsStreamFile("data.txt");
        $file->setContent(
            "test\ntest2"
        );
        $root->addChild($file);

        $streamable = new StreamableFile(new File(vfsStream::url("data/data.txt")));
        $result = [];
        foreach ($streamable as $it) {
            $result[] = $it;
        }
        self::assertThat($result, self::equalTo(['test', 'test2']));
    }
}
