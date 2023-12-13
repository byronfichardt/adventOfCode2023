<?php
// inspo from here
// https://github.com/pkusensei/adventofcode2023/blob/b8832055d4605674216c3333b71c5a05584483e7/d11/src/lib.rs
$input = file_get_contents(__DIR__ . '/input.txt');
$lines = explode("\n", $input);

$grid = array_map('str_split', $lines);

$indexOfEmptyRows = [];
foreach ($grid as $rowIndex => $row) {
    $isEmpty = count(array_filter($row, function ($char) {
        return $char === '.';
    })) === count($row);

    if ($isEmpty) {
        $indexOfEmptyRows[] = $rowIndex;
    }
}

$transposedGrid = array_map(null, ...$grid);
$indexOfEmptyCols = array_keys(array_map('join', $transposedGrid), str_repeat('.', count($grid)));

$allPositions = [];
foreach ($grid as $row => $line) {
    foreach ($line as $col => $char) {
        if ($char === '#') {
            $allPositions[] = [$row, $col];
        }
    }
}

$visited = [];
$total = 0;
for ($i = 0; $i < count($allPositions); $i++) {
    for ($j = $i + 1; $j < count($allPositions); $j++) {
        $position1 = $allPositions[$i];
        $position2 = $allPositions[$j];
        $result = calculatePaths($position1[0], $position1[1], $position2[0], $position2[1]);

        $result += coordinatesIntersectWithEmptyRows($position1, $position2, $indexOfEmptyRows);
        $result += coordinatesIntersectWithEmptyCols($position1, $position2, $indexOfEmptyCols);

        $total += $result;
    }
}

print_r($total);

function coordinatesIntersectWithEmptyCols($cord1, $cord2, $indexOfEmptyCols) {
    // Determine if the path intersects with any empty columns
    $intersectsWithEmptyCols = array_intersect($indexOfEmptyCols, range(min($cord1[1], $cord2[1]), max($cord1[1], $cord2[1])));

    return (1000000-1) * count($intersectsWithEmptyCols);
}

function coordinatesIntersectWithEmptyRows($cord1, $cord2, $indexOfEmptyRows) {
    $intersectsWithEmptyRows = array_intersect($indexOfEmptyRows, range(min($cord1[0], $cord2[0]), max($cord1[0], $cord2[0])));

    return (1000000-1) * count($intersectsWithEmptyRows);
}

// using manhattan distance
function calculatePaths($X1, $Y1, $X2, $Y2) {
    $horizontalDistance = abs($X1 - $X2);
    $verticalDistance = abs($Y1 - $Y2);
    
    $result = $horizontalDistance + $verticalDistance;

    return $result;
}

function dump($var) {
    print_r($var);
    print "\n";
}
