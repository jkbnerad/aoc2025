<?php

declare(strict_types=1);

$data = file_get_contents(__DIR__ . '/data.txt');
//$data = file_get_contents(__DIR__ . '/test-data.txt');

$pairs = explode(",", trim($data));

$twiceNumber = [];
foreach ($pairs as $pair) {
    [$a, $b] = explode("-", $pair);
    $a = (int)$a;
    $b = (int)$b;
    // 11-22
    for ($i = $a; $i <= $b; $i++) {
        $ch = (string)$i;
        $l = strlen($ch);
        $p1 = substr($ch, 0, (int)($l / 2));
        $p2 = substr($ch, (int)($l / 2));

        if ($p1 === $p2) {
            $twiceNumber[] = $i;
        }

    }
}


print array_sum($twiceNumber) . PHP_EOL;
