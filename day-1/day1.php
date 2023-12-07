<?php
$time = hrtime(true);
$total = 0;
$handle = fopen("data1.txt", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $numbers = checkLineHasSpelledNumber($line);
    
        $chars = str_split($line);
        foreach ($chars as $key => $char) {
            if (is_numeric($char)) {
                $numbers[$key] = (int)$char;
            }
        }
        ksort($numbers);
        $firstKey = array_key_first($numbers);

        $total += (int)((string)$numbers[$firstKey] . (string)end($numbers));
    }
    print_r($total);
    echo PHP_EOL;   
    fclose($handle);
    // total time for execution in milliseconds
    echo (hrtime(true) - $time) / 1e+6;
}

function checkLineHasSpelledNumber($line)
{
    $numbers = [
        'one' => 1,
        'two' => 2,
        'three' => 3,
        'four' => 4,
        'five' => 5,
        'six' => 6,
        'seven' => 7,
        'eight' => 8,
        'nine' => 9
    ];

    $numberWords = [];
    foreach ($numbers as $word => $number) {
        $count = substr_count($line, $word);
        $offset = 0;
        for ($i = 0; $i < $count; $i++) {
            if (strpos($line, $word, $offset) !== false) {
                $numberWords[strpos($line, $word, $offset)] = $number;
                $offset = strpos($line, $word, $offset) + strlen($word);
            }
        }
    }

    return $numberWords;
}