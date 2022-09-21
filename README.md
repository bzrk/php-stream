# PHP Stream

---
A library to handle Collections like in Java

## Stream Class
* public **count**(): int
* public **map**(Closure $call): Stream
* public **flatMap**(Closure $call): Stream
* public **filter**(Closure $call): Stream
* public **notNull**(): Stream
* public **notEmpty**(): Stream
* public **each**(Closure $call): void
* public **toList**(bool $keepKeys = false): array
* public **toMap**(Closure $key, Closure $value): array
* public **first**(): mixed
* public **limit**(int $size): Stream
* public **order**(Comparator $comparator): Stream
* public **run**(): Stream
* public **skip**(int $count): Stream
* public **implode**(string $separator = ','): string
* public **batch**(int $count): Stream
* public **associateBy**(Closure $call): array
* public **collect**(string $class): Collection
* public **toGenerator**(Closure $call = null, $default = null): Generator
* public **callBack**(Closure $call): Stream

## Streams Class
* public static **of**(array|Iterator|File|CsvFile $data): Stream
* public static **range**(int $start, int $inclusiveEnd): Stream
* public static **split**(string $pattern, string $source): Stream

## Examples

```php
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
//Result is
['hallo - 2', 'hallo - 3']
```

Create a Stream from a Typed Collection
```php
class User { ... }

class UserCollection extends Collection
{
    public function __construct(User ...$data)
    {
        parent::__construct($data);
    }

    public function add(User $value): void 
    {
        parent::addEntry($value);
    }
}   

(new UserCollection(new User("name")))->stream()->map(....)
```

more Examples in the testsuite.

## Running Test
```shell
composer verify
```
or
```shell
docker-compose up
```