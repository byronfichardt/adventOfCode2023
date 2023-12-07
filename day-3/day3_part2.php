<?php

function getAdjacentNumbersSum($schematic) {
    $lines = explode("\n", $schematic);
    $sum = 0;
    $visitedLocation = [];

    // Iterate over each line
    for ($i = 0; $i < count($lines); $i++) {
        $line = $lines[$i];

        // Iterate over each character in the line
        for ($j = 0; $j < strlen($line); $j++) {
            $currentChar = $line[$j];

            // Check if the current character is a symbol
            if (preg_match('/[*]/', $currentChar)) {
                // Check for adjacent numbers (up, down, left, right, and diagonals)
                $neighbors = [
                    [$i - 1, $j], [$i + 1, $j], [$i, $j - 1], [$i, $j + 1], [$i - 1, $j - 1], [$i - 1, $j + 1],
                    [$i + 1, $j - 1], [$i + 1, $j + 1]
                ];

                $neighborValues = [];
                foreach ($neighbors as $neighbor) {
                    [$row, $col] = $neighbor;

                    // Check if the neighbor is within bounds
                    if ($row >= 0 && $row < count($lines) && $col >= 0 && $col < strlen($line)) {
                        $neighborChar = $lines[$row][$col];
                        // Check if the neighbor is a number and has not been visited
                        if (is_numeric($neighborChar)) {

                            if (in_array([$row, $col], $visitedLocation)) {
                                continue;
                            }
                            
                            // Extract and sum the adjacent number
                            $number = $neighborChar;

                            // Use a temporary variable for $col in the loop
                            $tempCol = $col;

                            // Check for numbers that may start behind the current index
                            while ($tempCol - 1 >= 0 && is_numeric($lines[$row][$tempCol - 1])) {
                                $number = $lines[$row][--$tempCol] . $number;
                                $visitedLocation[] = [$row, $tempCol];
                            }

                            // Check for numbers that may end ahead of the current index
                            while ($col + 1 < strlen($line) && is_numeric($lines[$row][$col + 1])) {
                                $number .= $lines[$row][++$col];
                                $visitedLocation[] = [$row, $col];
                            }

                            echo "Number: $number\n";
                            $neighborValues[] = intval($number);
                        }
                    }

                    
                }
                echo "Neighbor values: " . implode(', ', $neighborValues) . "\n";
                if (count($neighborValues) === 2) {
                    //multiply the two numbers
                    $sum += $neighborValues[0] * $neighborValues[1];

                }
            }
        }
    }

    return $sum;
}

// Replace $engineSchematic with your actual engine schematic string
$engineSchematic = file_get_contents('input.txt');

$sum = getAdjacentNumbersSum($engineSchematic);

echo "Sum of valid part numbers: $sum\n";
