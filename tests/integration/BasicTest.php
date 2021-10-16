<?php

declare(strict_types=1);

namespace IntegrationTest;

use BZRK\PHPStream\Comparator;
use BZRK\PHPStream\Streams;
use PHPUnit\Framework\TestCase;

class BasicsTest extends TestCase
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
}
