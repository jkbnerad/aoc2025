<?php

declare(strict_types=1);
$start = microtime(true);

$data = file_get_contents(__DIR__ . '/data.txt'); // 12377473011151
//$data = file_get_contents(__DIR__ . '/test-data.txt'); // 3263827

$lines = explode("\n", trim($data));

$actions = $hasSpace = [];
foreach ($lines as $line) {
    $tmp = [];
    for ($i = 0, $iMax = strlen($line); $i < $iMax; $i++) {
        if ($line[$i] === ' ') {
            $tmp[$i] = 1;
        } else {
            $tmp[$i] = 0;
        }
    }

    $hasSpace[] = $tmp;
}

$hasSpacesTranspose = [];
// transpose
foreach ($hasSpace as $rowIndex => $row) {
    foreach ($row as $col => $colValue) {
        $hasSpacesTranspose[$col][] = $colValue;
    }
}

$spaceIndices = [];
// find columns with only spaces
foreach ($hasSpacesTranspose as $index => $values) {
    if (array_sum($values) === count($values)) {
        $spaceIndices[] = $index;
    }
}

$matrix = [];
foreach ($lines as $line) {
    $tmp = [];
    $k = 0;
    for ($i = 0, $iMax = strlen($line); $i < $iMax; $i++) {
        if (in_array($i, $spaceIndices, true)) {
            $k++;
        } else {
            $ch = isset($tmp[$k]) ? $tmp[$k] . $line[$i] : $line[$i];
            $tmp[$k] = $ch;
        }
    }
    $matrix[] = $tmp;
}


$actions = array_pop($matrix);
$matrixTranspose = [];
// transpose
foreach ($matrix as $row) {
    foreach ($row as $col => $value) {
        $matrixTranspose[$col][] = $value;
    }
}

$numbers = [];
foreach ($matrixTranspose as $c => $numbersStr) {
    $tmp = [];
    foreach ($numbersStr as $char) {
        for ($i = 0, $iMax = strlen($char); $i < $iMax; $i++) {
            $ch = $char[$i];
            if ($ch !== ' ') {
                $tmp[$i][] = (int)$ch;
            } else {
                $tmp[$i][] = '';
            }
        }
    }
    $numbers[$c] = ($tmp);
}

$finalNumbers = [];
foreach ($numbers as $hasSpacesTranspose => $numbersStr) {
    foreach ($numbersStr as $numArr) {
        $tmp = implode('', $numArr);
        $finalNumbers[$hasSpacesTranspose][] = $tmp;
    }
}

$sum = 0;
foreach($finalNumbers as $hasSpacesTranspose => $numbers) {
    $action = trim($actions[$hasSpacesTranspose]);
    if ($action === '*') {
        $result = 1;
        foreach($numbers as $number) {
            $result *= $number;
        }
        $sum += $result;
    } elseif ($action === '+') {
        $result = array_sum($numbers);
        $sum += $result;
    }
}

print  "Sum: $sum";
