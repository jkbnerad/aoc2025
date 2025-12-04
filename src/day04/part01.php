<?php

declare(strict_types=1);
$start = microtime(true);

$data = file_get_contents(__DIR__ . '/data.txt');
//$data = file_get_contents(__DIR__ . '/test-data.txt');

$lines = explode("\n", trim($data));


$c = strlen($lines[0]);
$r = count($lines);


$m = [];
$xCount = 0;
for ($i = 0; $i < $c; $i++) {
    for ($j = 0; $j < $r; $j++) {
        $currentChar = $lines[$i][$j];
        if ($currentChar !== '@') {
            continue;
        }

        $m[$i][$j] = $currentChar;
        $count = 0;
        for ($q = -1; $q <= 1; $q++) {
            for ($s = -1; $s <= 1; $s++) {

                $ni = $i+$q;
                $nj = $j+$s;

                if(($ni === $i && $nj === $j) || ($ni < 0 || $nj < 0 || $ni >= $c || $nj >= $r)) {
                    continue;
                }

                $ch2 = $lines[$ni][$nj] ?? null;
                if ($ch2 === '@') {
                    $count++;
                }
            }
        }

        if ($count < 4) {
            $m[$i][$j] = 'x';
            $xCount++;
        }

    }
}

print "X count: " . $xCount . PHP_EOL;
$end = microtime(true);
$time = $end - $start;
print "Time: " . $time . " s" . PHP_EOL;
