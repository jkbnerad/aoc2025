<?php

declare(strict_types=1);
$start = microtime(true);

$data = file_get_contents(__DIR__ . '/data.txt');
//$data = file_get_contents(__DIR__ . '/test-data.txt');

[$ranges, $ingredients] = explode("\n\n", trim($data));

$ranges = explode("\n", trim($ranges));
$ingredients = explode("\n", trim($ingredients));

$fresh = [];
foreach($ranges as $range) {
    [$a, $b] = explode("-", $range);
    foreach ($ingredients as $ingredient) {
        $num = (int)$ingredient;
        if (isset($fresh[$num])) {
            continue;
        }
        if ($num >= (int)$a && $num <= (int)$b) {
            $fresh[$num] = $num;
        }
    }
}

print "Fresh ingredients sum: " . count($fresh) . PHP_EOL;

$end = microtime(true);
$time = $end - $start;
print "Time: " . $time . " s" . PHP_EOL;
