<?php

declare(strict_types=1);
$start = microtime(true);

$data = file_get_contents(__DIR__ . '/data.txt');
//$data = file_get_contents(__DIR__ . '/test-data.txt');

$lines = explode("\n", trim($data));

$numberLines = [];
$actions = [];
foreach($lines as $line) {
    // 10    11 12 1 11     23
    $parts = preg_split('/\s+/', trim($line));
    foreach($parts as $c => $part) {
        if (preg_match('/\d+/', $part)) {
            $numberLines[$c][] = (int)$part;
        } else {
            $actions[$c] = $part;
        }
    }
}

$sum = 0;
foreach($numberLines as $c => $numbers) {
    $action = $actions[$c];
    if ($action === '*') {
        $result = 1;
        foreach($numbers as $number) {
            $result *= $number;
        }
//        print "Column $c multiplication result: " . $result . PHP_EOL;
        $sum += $result;
    } elseif ($action === '+') {
        $result = array_sum($numbers);
//        print "Column $c sum result: " . $result . PHP_EOL;
        $sum += $result;
    }
}

print  "Sum: $sum";
