<?php

declare(strict_types=1);
$start = microtime(true);

//$data = file_get_contents(__DIR__ . '/data.txt');
$data = file_get_contents(__DIR__ . '/test-data.txt');
[$rangesData,] = explode("\n\n", trim($data));

$intervals = [];
foreach (explode("\n", trim($rangesData)) as $range) {
    [$a, $b] = array_map('intval', explode("-", $range));
    $intervals[] = [$a, $b];
}

// sort intervals by start value
usort($intervals, static fn($x, $y) => $x[0] <=> $y[0]);

$merged = [];
// [[1,4], [3,7], [10,12]]
foreach ($intervals as [$a, $b]) {
    $lastKey = array_key_last($merged);
    if ($merged === [] || $merged[$lastKey][1] < $a - 1) { // [10,12]
        $merged[] = [$a, $b];
    } else { // [1, 4] and [3,7] => [1, 7]
        $merged[$lastKey][1] = max($merged[$lastKey][1], $b); // merge intervals
    }
}

$sum = 0;
foreach ($merged as [$a, $b]) {
    $sum += ($b - $a + 1);
}

var_dump($merged);
var_dump($sum);
