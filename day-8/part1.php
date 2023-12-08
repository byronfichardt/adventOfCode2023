<?php

$input = file_get_contents(__DIR__ . '/input.txt');

$lines = explode("\n", $input);

$instructions = [];
$nodes = [];
foreach ($lines as $key => $line) {
    if ($key == 0 ) {
        $instructions = str_split($line);
        continue;
    }
    if (empty($line )) {
        continue;
    }
    $parts = str_replace(' = ',',', $line);
    $parts = str_replace('(','', $parts);
    $parts = str_replace(')','', $parts);
    $parts = explode(',', $parts);
    $parts = array_map('trim', $parts);
    $nodes[$parts[0]] = [$parts[1], $parts[2]];
}

$count = 0;
$answer = 'AAA';
$node = $nodes['AAA'];
while($answer != 'ZZZ') {
    [$nodeValue, $node]= loop($instructions, $nodes, $count, $node);
    $answer = $nodeValue;
}

function loop($instructions, $nodes, &$count, $node) {;
    $answer = '';
    foreach ($instructions as $instruction) {
        if ($instruction == 'L') {
            $answer = $node[0];
            if ($answer == 'ZZZ') {
                $count++;
                return [$answer, $node];
                break;
            }
            $node = $nodes[$node[0]];
        } else {
            $answer = $node[1];
            if ($answer == 'ZZZ') {
                $count++;
                return [$answer, $node];
                break;
            }
            $node = $nodes[$node[1]];
        }
        $count++;
    }
    return [$answer, $node];
}

echo $count;

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