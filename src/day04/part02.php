<?php

declare(strict_types=1);

$start = microtime(true);

$data = file_get_contents(__DIR__ . '/data.txt');
//$data = file_get_contents(__DIR__ . '/test-data.txt');

$lines = explode("\n", trim($data));


$c = strlen($lines[0]);
$r = count($lines);

$matrix = [];
$totalXCount = $rounds = 0;
for ($i = 0; $i < $c; $i++) {
    for ($j = 0; $j < $r; $j++) {
        $matrix[$i][$j] = $lines[$i][$j];
    }
}

while (true) {
    $xCount = 0;
    $tmp = $matrix;
    for ($i = 0; $i < $c; $i++) {
        for ($j = 0; $j < $r; $j++) {
            $currentChar = $matrix[$i][$j];

            if ($currentChar !== '@') {
                continue;
            }

            $count = 0;
            for ($q = -1; $q <= 1; $q++) {
                for ($s = -1; $s <= 1; $s++) {
                    $ni = $i + $q;
                    $nj = $j + $s;

                    if (($ni === $i && $nj === $j) || ($ni < 0 || $nj < 0)) { // out of area
                        continue;
                    }

                    $neighbour = $tmp[$ni][$nj] ?? null;
                    if ($neighbour === '@') {
                        $count++;
                    }
                }
            }

            if ($count < 4) {
                $matrix[$i][$j] = 'x';
                $xCount++;
            }
        }
    }

    if ($xCount === 0) {
        break;
    }

    $totalXCount += $xCount;
}


print "X count: " . $totalXCount . PHP_EOL;
$end = microtime(true);
$time = $end - $start;
print "Time: " . $time . " s" . PHP_EOL;

