<?php

declare(strict_types=1);

namespace unit\BZRK\PHPStream;

use BZRK\PHPStream\Comparator;
use BZRK\PHPStream\Stream;
use BZRK\PHPStream\Streamable\StreamableArray;
use BZRK\PHPStream\Streamable\StreamableRange;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class StreamTest extends TestCase
{
    #[Test]
    public function counting(): void
    {
        $stream = new Stream(new StreamableRange(1, 5));
        $result = $stream->count();

        self::assertThat($result, self::equalTo(5));
    }

    #[Test]
    public function toList(): void
    {
        $stream = new Stream(new StreamableRange(1, 5));
        $result = $stream->toList();

        self::assertThat($result, self::equalTo([1, 2, 3, 4, 5]));
    }

    #[Test]
    public function toMap(): void
    {
        $stream = new Stream(new StreamableArray([
            (object)['id' => 1, 'name' => 'name1'],
            (object)['id' => 2, 'name' => 'name2'],
        ]));
        $result = $stream->toMap(fn($it) => $it->id, fn($it) => $it->name);

        self::assertThat($result, self::equalTo([
            1 => 'name1',
            2 => 'name2',
        ]));
    }

    #[Test]
    public function each(): void
    {
        $values = [];
        $keys = [];
        $stream = new Stream(new StreamableRange(2, 5));
        $stream->each(function ($value, $key) use (&$values, &$keys) {
            $values[] = $value;
            $keys[] = $key;
        });

        self::assertThat($values, self::equalTo([2, 3, 4, 5]));
        self::assertThat($keys, self::equalTo([0, 1, 2, 3]));
    }

    #[Test]
    public function map(): void
    {
        $stream = new Stream(new StreamableRange(1, 5));
        $result = $stream->map(fn($it) => $it * 2)->toList();

        self::assertThat($result, self::equalTo([2, 4, 6, 8, 10]));
    }

    #[Test]
    public function flatMap(): void
    {
        $data = [
            [1, 2],
            [3, 4, 5]
        ];

        $stream = new Stream(new StreamableArray($data));
        $result = $stream->flatMap(fn(int $it) => $it)->toList();

        self::assertThat($result, self::equalTo([1, 2, 3, 4, 5]));
    }

    #[Test]
    public function mapFlatMap(): void
    {
        $data = [
            ['objs' => [['data' => [1, 2]], ['data' => [3, 4]]]],
            ['objs' => [['data' => [5, 6]], ['data' => [7, 8]]]]
        ];

        $stream = new Stream(new StreamableArray($data));
        $result = $stream
            ->map(fn(array $it) => $it['objs'])
            ->flatMap(fn(array $it) => $it['data'])
            ->flatMap(fn(int $it) => $it)
            ->toList();

        self::assertThat($result, self::equalTo([1, 2, 3, 4, 5, 6, 7, 8]));
    }

    #[Test]
    public function filter(): void
    {
        $stream = new Stream(new StreamableRange(1, 5));
        $result = $stream->filter(fn($it) => $it % 2 === 0)->toList();

        self::assertThat($result, self::equalTo([2, 4]));
    }

    #[Test]
    public function notNull(): void
    {
        $stream = new Stream(new StreamableArray([0, "", '', [], null, 2, 3]));
        $result = $stream->notNull()->toList();

        self::assertThat($result, self::equalTo([0, "", '', [], 2, 3]));
    }

    #[Test]
    public function notEmpty(): void
    {
        $stream = new Stream(new StreamableArray([0, "", '', [], null, 2, 3]));
        $result = $stream->notEmpty()->toList();

        self::assertThat($result, self::equalTo([2, 3]));
    }

    #[Test]
    public function first(): void
    {
        $stream = new Stream(new StreamableRange(1, 5));
        $result = $stream->first();

        self::assertThat($result, self::equalTo(1));
    }

    #[Test]
    public function limit(): void
    {
        $stream = new Stream(new StreamableRange(1, 5));
        $result = $stream->limit(3)->toList();

        self::assertThat($result, self::equalTo([1, 2, 3]));
    }

    #[Test]
    public function skip(): void
    {
        $stream = new Stream(new StreamableRange(1, 5));
        $result = $stream->skip(2)->toList();

        self::assertThat($result, self::equalTo([3, 4, 5]));
    }

    #[Test]
    public function order(): void
    {
        $stream = new Stream(new StreamableArray([4, 2, 6, 9]));
        $result = $stream->order(Comparator::int())->toList();

        self::assertThat($result, self::equalTo([2, 4, 6, 9]));
    }

    #[Test]
    public function implodeDefault(): void
    {
        $stream = new Stream(new StreamableArray(["a", "b", "c", "d"]));
        $result = $stream->implode();
        self::assertThat($result, self::equalTo("a,b,c,d"));
    }

    #[Test]
    public function implode(): void
    {
        $stream = new Stream(new StreamableArray(["a", "b", "c", "d"]));
        $result = $stream->implode(";");
        self::assertThat($result, self::equalTo("a;b;c;d"));
    }
}
