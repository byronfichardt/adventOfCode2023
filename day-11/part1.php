<?php

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

foreach ($indexOfEmptyRows as $key => $row) {
    if ($row < count($grid)) {
        $grid = addRowAtIndex($grid, $row + $key);
    }
}

$transposedGrid = array_map(null, ...$grid);
$indexOfEmptyCols = array_keys(array_map('join', $transposedGrid), str_repeat('.', count($grid)));

foreach ($indexOfEmptyCols as $key => $col) {
    if ($col < count($grid[0])) {
        $grid = addColumnAtIndex($grid, $col + $key);
    }
}

$allPositions = [];
foreach ($grid as $row => $line) {
    foreach ($line as $col => $char) {
        if ($char === '#') {
            $allPositions[] = [$row, $col];
        }
    }
}

// sort by row, then by column
usort($allPositions, function ($a, $b) {
    if ($a[0] === $b[0]) {
        return $a[1] <=> $b[1];
    }
    return $a[0] <=> $b[0];
});

$visited = [];
$total = 0;
for ($i = 0; $i < count($allPositions); $i++) {
    for ($j = $i + 1; $j < count($allPositions); $j++) {
        $position1 = $allPositions[$i];
        $position2 = $allPositions[$j];
        $result = calculatePaths($position1[0], $position1[1], $position2[0], $position2[1]);
        $total += $result;
    }
}

print_r($total);

function calculatePaths($X1, $Y1, $X2, $Y2) {
    $horizontalDistance = abs($X1 - $X2);
    $verticalDistance = abs($Y1 - $Y2);
    
    $result = $horizontalDistance + $verticalDistance;

    return $result;
}

function addRowAtIndex($grid, $rowIndex) {
    $cols = count($grid[0]);

    // Add a new row with dots at the specified index
    array_splice($grid, $rowIndex, 0, [array_fill(0, $cols, '.')]);

    return $grid;
}

function addColumnAtIndex($grid, $colIndex) {
    foreach ($grid as &$row) {
        array_splice($row, $colIndex, 0, ['.']);
    }
    return $grid;
}

function dump($var) {
    print_r($var);
    print "\n";
}
