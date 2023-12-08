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

$nodeKeys = [];
foreach ($nodes as $key => $node) {
    $splitKey = str_split($key);
    if ($splitKey[2] == 'A') {
        $nodeKeys[] = $key;
    }
}

$count = 1;
$answer = false;
while(!$answer) {
    [$nodeKeys, $count, $answer] = loop($instructions, $nodes, $count, $nodeKeys);
}


function loop($instructions, $nodes, &$count, &$nodeKeys) {;
    $start=hrtime(true);
    $answer = '';
    foreach ($instructions as $key => $instruction) {
        $nodeKeyAnswers = [];
        foreach ($nodeKeys as $key2 => $nodeKey) {
            $node = $nodes[$nodeKey];
            if ($instruction == 'L') {
                $answer = str_split($node[0]);
                if ($answer[2] == 'Z') {
                    $nodeKeyAnswers[] = 1;
                    $nodeKeys[$key2] = $node[0];
                    continue;
                }
                $nodeKeys[$key2] = $node[0];
            } else {
                $answer = str_split($node[1]);
                if ($answer[2] == 'Z') {
                    $nodeKeyAnswers[] = 1;
                    $nodeKeys[$key2] = $node[1];
                    continue;
                }
                $nodeKeys[$key2] = $node[1];
            }
        }

        if (array_sum($nodeKeyAnswers) == count($nodeKeys)) {
            dump('answered');
            return [$nodeKeys, $count, true];
            break;
        }
       
        $count++;
        
    }
    $end=hrtime(true);
    $diff=($end-$start);
    // print "Time: $diff\n";
    echo $diff . "\n";
    dd('');
    return [$nodeKeys, $count, false];
}

// brute force wont work use lcm
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