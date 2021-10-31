<?php

declare(strict_types=1);

namespace unit\BZRK\PHPStream;

use BZRK\PHPStream\Comparator;
use BZRK\PHPStream\Stream;
use BZRK\PHPStream\Streamable\StreamableArray;
use BZRK\PHPStream\Streamable\StreamableRange;
use PHPUnit\Framework\TestCase;

class StreamTest extends TestCase
{
    public function testCount(): void
    {
        $stream = new Stream(new StreamableRange(1, 5));
        $result = $stream->count();

        self::assertThat($result, self::equalTo(5));
    }

    public function testToList(): void
    {
        $stream = new Stream(new StreamableRange(1, 5));
        $result = $stream->toList();

        self::assertThat($result, self::equalTo([1, 2, 3, 4, 5]));
    }

    public function testToMap(): void
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

    public function testEach(): void
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

    public function testMap(): void
    {
        $stream = new Stream(new StreamableRange(1, 5));
        $result = $stream->map(fn($it) => $it * 2)->toList();

        self::assertThat($result, self::equalTo([2, 4, 6, 8, 10]));
    }

    public function testFlatMap(): void
    {
        $data = [
            [1, 2],
            [3, 4, 5]
        ];

        $stream = new Stream(new StreamableArray($data));
        $result = $stream->flatMap(fn(int $it) => $it)->toList();

        self::assertThat($result, self::equalTo([1, 2, 3, 4, 5]));
    }

    public function testMapFlatMap(): void
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

    public function testFilter(): void
    {
        $stream = new Stream(new StreamableRange(1, 5));
        $result = $stream->filter(fn($it) => $it % 2 === 0)->toList();

        self::assertThat($result, self::equalTo([2, 4]));
    }

    public function testNotNull(): void
    {
        $stream = new Stream(new StreamableArray([0, "", '', [], null, 2, 3]));
        $result = $stream->notNull()->toList();

        self::assertThat($result, self::equalTo([0, "", '', [], 2, 3]));
    }

    public function testNotEmpty(): void
    {
        $stream = new Stream(new StreamableArray([0, "", '', [], null, 2, 3]));
        $result = $stream->notEmpty()->toList();

        self::assertThat($result, self::equalTo([2, 3]));
    }

    public function testFirst(): void
    {
        $stream = new Stream(new StreamableRange(1, 5));
        $result = $stream->first();

        self::assertThat($result, self::equalTo(1));
    }

    public function testLimit(): void
    {
        $stream = new Stream(new StreamableRange(1, 5));
        $result = $stream->limit(3)->toList();

        self::assertThat($result, self::equalTo([1, 2, 3]));
    }

    public function testSkip(): void
    {
        $stream = new Stream(new StreamableRange(1, 5));
        $result = $stream->skip(2)->toList();

        self::assertThat($result, self::equalTo([3, 4, 5]));
    }

    public function testOrder(): void
    {
        $stream = new Stream(new StreamableArray([4, 2, 6, 9]));
        $result = $stream->order(Comparator::int())->toList();

        self::assertThat($result, self::equalTo([2, 4, 6, 9]));
    }

    public function testImplodeDefault(): void
    {
        $stream = new Stream(new StreamableArray(["a", "b", "c", "d"]));
        $result = $stream->implode();
        self::assertThat($result, self::equalTo("a,b,c,d"));
    }

    public function testImplode(): void
    {
        $stream = new Stream(new StreamableArray(["a", "b", "c", "d"]));
        $result = $stream->implode(";");
        self::assertThat($result, self::equalTo("a;b;c;d"));
    }
}
