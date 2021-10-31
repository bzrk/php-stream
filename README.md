# PHP Stream

---
A library to handle Collections like in Java

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

more Examples in the testsuite.

## Running Test
```shell
composer verify
```
or
```shell
docker-compose up
```