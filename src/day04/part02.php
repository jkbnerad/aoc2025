<?php

declare(strict_types=1);

$data = file_get_contents(__DIR__ . '/data.txt');
//$data = file_get_contents(__DIR__ . '/test-data.txt');

$lines = explode("\n", trim($data));

$start = microtime(true);
$numbers = [];
$batterySize = 12;
foreach ($lines as $line) {
    $sLength = 0;
    $l = strlen($line);
    $max = null;
    $s = '';
    $p = PHP_INT_MIN;
    for ($i = 0; $i < $l; $i++) {
        $max = PHP_INT_MIN;
        if ($p >= $i) { // posunuti na spravnou pozici
            continue;
        }
        $needDigits = $batterySize - $sLength;
        for ($j = $i; $j < $l; $j++) {
            $currentPosition = $l - $j;
            $a = (int)$line[$j];
            if ($max < $a) {
                $p = $j; // potrebuji si pamatovat pozici
                $max = $a;
            }

            if ($needDigits >= $currentPosition) { // neni dostatek zbyvajicich cisel, vezmu nejvetsi
                $s .= $max;
                $sLength++;
                break;
            }
        }
    }

    $numbers[] = $s;
}

$time = microtime(true) - $start;
print "Time: " . $time . " s" . PHP_EOL;
print array_sum($numbers) . PHP_EOL;
