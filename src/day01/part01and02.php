<?php

declare(strict_types=1);

$data = file_get_contents(__DIR__ . '/data.txt');
// $data = file_get_contents(__DIR__ . '/test-data.txt');

$lines = explode("\n", $data);
$moves = [];
$regexLine = '/^([LR])(\d+)$/';
foreach ($lines as $line) {
    $value = trim($line);
    if (preg_match($regexLine, $value, $matches)) {
        $direction = $matches[1];
        $steps = (int)$matches[2];
        $moves[] = ['direction' => $direction, 'steps' => $steps];
    }
}

// @TODO: use modulo operator to optimize performance
$moveFnc = static function (int $position, int $steps, &$zerosEnd, &$zerosAll): int {
    $min = 0;
    $max = 99;
    if ($steps < 0) {
        for ($i = 0; $i < abs($steps); $i++) {
            if (--$position === 0) {
                $zerosAll++;
            }

            if ($position < $min) {
                $position = 99;
            }
        }
    } else {
        for ($i = 0; $i < $steps; $i++) {
            if (++$position > $max) {
                $position = 0;
                $zerosAll++;
            }
        }
    }

    if ($position === 0) {
        $zerosEnd++;
    }

    return $position;
};

$position = 50;
$zerosEnd = $zerosAll = 0;
foreach ($moves as $m) {
    $position = $moveFnc($position, ($m['direction'] === 'L' ? -1 : 1) * $m['steps'], $zerosEnd, $zerosAll);
}

// part 1
print $zerosEnd . PHP_EOL;
// part 2
print $zerosAll . PHP_EOL;
