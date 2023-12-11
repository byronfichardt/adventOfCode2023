<?php

$file = file_get_contents(__DIR__ . '/input.txt');
$grid = [];

foreach (explode("\n", $file) as $row => $line) {
    foreach (str_split($line) as $col => $char) {
        $grid[$row][$col] = $char;
    }
}

// find the starting location S in the grid
foreach ($grid as $row => $line) {
    foreach ($line as $col => $char) {
        if ($char === 'S') {
            $start = [$row, $col];
        }
    }
}

$count = 1;
[$next_position, $previous_position] = get_next_position($start, $start, $grid);
$value = $grid[$next_position[0]][$next_position[1]];

$allpositions = [];

$allpositions[] = $next_position;

while ($value !== 'S') {
    [$next_position, $previous_position] = get_next_position($next_position, $previous_position, $grid);

    $value = $grid[$next_position[0]][$next_position[1]];
    $allpositions[] = $next_position;
    $count++;
}

// apply shoelace formulae to determine the area of the polygon
$area = 0;
for ($i = 0; $i < count($allpositions) - 1; $i++) {
    $area += $allpositions[$i][0] * $allpositions[$i + 1][1];
    $area -= $allpositions[$i][1] * $allpositions[$i + 1][0];
}
$area += $allpositions[count($allpositions) - 1][0] * $allpositions[0][1];
$area -= $allpositions[count($allpositions) - 1][1] * $allpositions[0][0];

$area = abs($area / 2);

// Count the number of boundary points
$boundaryPoints = count($allpositions);

// Apply Pick's theorem to find the number of interior points
$internal_points = $area - $boundaryPoints/2 + 1;

dump(count($allpositions));
dump($area);
dd($internal_points);

function get_next_position($starting_position, $previous_position, $grid) {
    $tests = [
        "S" => [
            "T" => "7F|", "B" => "JL|", "L" => "LF-", "R" => "7J-",
        ],
        "|" => [
            "T" => "7F|S", "B" => "JL|S", "L" => "", "R" => "",
        ],
        "-" => [
            "T" => "", "B" => "", "L" => "LF-S", "R" => "7J-S",
        ],
        "L" => [
            "T" => "7F|S", "B" => "", "L" => "", "R" => "7J-S",
        ],
        "J" => [
            "T" => "7F|S", "B" => "", "L" => "LF-S", "R" => "",
        ],
        "7" => [
            "T" => "", "B" => "JL|S", "L" => "LF-S", "R" => "",
        ],
        "F" => [
            "T" => "", "B" => "JL|S", "L" => "", "R" => "7J-S",
        ],
    ];

    // can i move up 
    $possible_moves = [];
    $current_value = $grid[$starting_position[0]][$starting_position[1]];
    $previous_value = $grid[$previous_position[0]][$previous_position[1]];
    $up = [$starting_position[0] - 1, $starting_position[1]];
    
    $possible_moves = [];

    // Check upward move
    checkMove('T', [-1, 0], 'up', $possible_moves, $grid, $tests, $current_value, $starting_position);

    // Check downward move
    checkMove('B', [1, 0], 'down', $possible_moves, $grid, $tests, $current_value, $starting_position);

    // Check leftward move
    checkMove('L', [0, -1], 'left', $possible_moves, $grid, $tests, $current_value, $starting_position);

    // Check rightward move
    checkMove('R', [0, 1], 'right', $possible_moves, $grid, $tests, $current_value, $starting_position);

    foreach ($possible_moves as $move) {
        // does the move = previous position
        if ($move != $previous_position) {
            $next_position = $move;
        }
    }

    if (!isset($next_position)) {
        dump($starting_position);
        dd($possible_moves);
    }

    return [$next_position, $starting_position];
}

function checkMove($direction, $offset, $axis, &$possible_moves, $grid, $tests, $current_value, $starting_position) {
    $newPosition = [$starting_position[0] + $offset[0], $starting_position[1] + $offset[1]];
    
    if (isset($grid[$newPosition[0]][$newPosition[1]])) {
        $value = $grid[$newPosition[0]][$newPosition[1]];
        
        if (isset($tests[$current_value][$direction]) && strpos($tests[$current_value][$direction], $value) !== false) {
            $possible_moves[$axis] = $newPosition;
        }
    }
}


function dump($var)
{
    print_r($var);
    echo "\n";
}

function dd($var)
{
    print_r($var);
    die();
}