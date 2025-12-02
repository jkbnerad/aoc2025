<?php

declare(strict_types=1);

$data = file_get_contents(__DIR__ . '/data.txt');
//$data = file_get_contents(__DIR__ . '/test-data.txt');

$pairs = explode(",", trim($data));

$sum = 0;
foreach ($pairs as $pair) {
    [$idStart, $idEnd] = array_map('intval', explode("-", $pair));
    for ($i = $idStart; $i <= $idEnd; $i++) {
        $ch = (string)$i;
        $length = strlen($ch);
        if ($length < 2) {
            continue;
        }
        $halfLength = intdiv($length, 2);
        $patterns = [];
        $countPatterns = 0;
        for ($j = 0; $j < $halfLength; $j++) {
            if ($length % ($j + 1) !== 0) { // only full patterns
                continue;
            }
            $p = substr($ch, 0, $j + 1);
            $patterns[$j + 1] = $p;
        }

        // optimalizace - asi by to slo udelat lepe, neco jako:
        // $reconstructed = str_repeat($pattern, $length / $len);
        //
        // if ($ch === $reconstructed) {
        //     $isTwice = true;
        //     break;
        // }

        $twiceNumberTmp = [];
        foreach ($patterns as $patternLength => $pattern) {
            $lpl = intdiv($length, $patternLength);
            $partsLength = 0;
            $previousPart = null;
            $isSame = false;
            for ($q = 0; $q < $lpl; $q++) {
                $part = substr($ch, $q * $patternLength, $patternLength);
                $partsLength += $patternLength;

                if ($previousPart !== null && $previousPart !== $part) {
                    $isSame = false;
                    break;
                }

                if ($previousPart === $part) {
                    $isSame = true;
                }
                $previousPart = $part;
            }

            if ($isSame === true && $partsLength === $length) {
                $twiceNumberTmp[] = $i;
            }

        }

        if ($twiceNumberTmp !== []) {
            $sum += array_sum(array_unique($twiceNumberTmp));
        }

    }
}

print ($sum) . PHP_EOL;
