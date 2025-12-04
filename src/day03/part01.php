<?php

declare(strict_types=1);

$data = file_get_contents(__DIR__ . '/data.txt');
//$data = file_get_contents(__DIR__ . '/test-data.txt');

$lines = explode("\n", trim($data));

//$lines = ['234234234234278'];

$start = microtime(true);
$numbers = [];
foreach ($lines as $line) {
    $l = strlen($line);
    $max = null;
    for ($i = 0; $i < $l; $i++) {
        $a = (int)$line[$i];

        $strMax = (string)$max;
        if ($strMax !== '' && $a < (int)$strMax[0]) {
            continue;
        }

        for ($j = $i + 1; $j < $l; $j++) {
            $b = (int)$line[$j];
            $number = (int)($a . $b);
            if ($max === null || $number > $max) {
                $max = $number;
            }
        }
    }
    if ($max !== null) {
        $numbers[] = $max;
    }
}

$end = microtime(true);
$time = $end - $start;
print "Time: " . $time . " s" . PHP_EOL;
print array_sum($numbers) . PHP_EOL;
