<?php

declare(strict_types=1);

namespace integration;

use BZRK\PHPStream\Collection\IntCollection;
use BZRK\PHPStream\Collection\StringCollection;
use BZRK\PHPStream\Comparator;
use BZRK\PHPStream\StreamException;
use BZRK\PHPStream\Streams;
use Exception;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\equalTo;

class BasicTest extends TestCase
{
    public function testMapFilterOrderMapComplexObjects(): void
    {
        $data = [
            (object)["name" => "hallo", "data" => ["a", "b"]],
            (object)["name" => "hallo", "data" => ["a", "b", "H", "g"]],
            (object)["name" => "hallo", "data" => ["a", "b", "d"]],
        ];

        $result = Streams::of($data)
            ->map(fn(object $obj) => (object)["name" => $obj->name, "cnt" => count($obj->data)])
            ->filter(fn(object $obj) => $obj->cnt !== 4)
            ->order(new Comparator(fn(object $a, object $b) => $a->cnt - $b->cnt))
            ->map(fn(object $obj) => "$obj->name - $obj->cnt")
            ->toList();
        self::assertThat($result, self::equalTo(['hallo - 2', 'hallo - 3']));
    }

    public function testGetFirstObjectWithHAndGInDataSkipOne(): void
    {
        $data = [
            (object)["name" => "hallo1", "data" => ["a", "b"]],
            (object)["name" => "hallo2", "data" => ["a", "b", "H", "G"]],
            (object)["name" => "hallo3", "data" => ["a", "b", "d"]],
            (object)["name" => "hallo4", "data" => ["a", "b", "d", "H", "G"]],
            (object)["name" => "hallo5", "data" => ["r", "z", "d", "H", "G"]],
        ];

        $result = Streams::of($data)
            ->filter(fn(object $obj) => in_array('H', $obj->data) && in_array('G', $obj->data))
            ->skip(1)
            ->first();
        self::assertThat($result, self::equalTo((object)["name" => "hallo4", "data" => ["a", "b", "d", "H", "G"]]));
    }

    public function testSkipAndLimitARangeToMap(): void
    {
        $result = Streams::range(0, 20)
            ->skip(4)
            ->limit(5)
            ->toMap(fn($it) => $it, fn($it) => $it * 10);
        self::assertThat($result, self::equalTo([
            4 => 40,
            5 => 50,
            6 => 60,
            7 => 70,
            8 => 80,
        ]));
    }

    public function testSplit(): void
    {
        $result = Streams::split("/[;,]/", "a;b,c.d")->toList();
        self::assertThat($result, self::equalTo(['a', 'b', 'c.d']));
    }

    public function testFilterWithKey(): void
    {
        $result = Streams::of(['a' => 'b', 'c' => 'd'])->filter(fn($val, $key) => $key === 'c')->toList(true);
        self::assertThat($result, self::equalTo(['c' => 'd']));
    }

    public function testFirst(): void
    {
        $store = [];

        $result = Streams::range(1, 5)
            ->map(
                function (int $it) use (&$store) {
                    $store[] = $it;
                    return $it;
                }
            )
            ->first();

        self::assertThat($store, self::equalTo([1]));
        self::assertThat($result, self::equalTo(1));
    }

    public function testRunFirst(): void
    {
        $store = [];

        $result = Streams::range(1, 5)
            ->map(
                function (int $it) use (&$store) {
                    $store[] = $it;
                    return $it;
                }
            )
            ->run()
            ->first();

        self::assertThat($store, self::equalTo([1, 2, 3, 4, 5]));
        self::assertThat($result, self::equalTo(1));
    }

    public function testAssociateBy(): void
    {
        $result = Streams::range(1, 5)->associateBy(fn($it) => $it * 2);

        self::assertThat($result, self::equalTo(
            [2 => 1, 4 => 2, 6 => 3, 8 => 4, 10 => 5]
        ));
    }

    /**
     * @throws StreamException
     */
    public function testCollect(): void
    {
        $result = Streams::range(1, 5)->collect(IntCollection::class);

        self::assertThat($result, self::isInstanceOf(IntCollection::class));
        self::assertThat($result->stream()->implode(), equalTo('1,2,3,4,5'));
    }

    public function testCollectWrongCollectionType(): void
    {
        self::expectException(StreamException::class);
        self::expectExceptionMessage('$class not from type BZRK\PHPStream\Collection');

        Streams::range(1, 5)->collect(Exception::class);
    }

    public function testCollectWrongEntryTypeOfCollection(): void
    {
        self::expectException(StreamException::class);
        self::expectExceptionMessageMatches('/Argument #1 must be of type string, int given,/');

        Streams::range(1, 5)->collect(StringCollection::class);
    }
}
