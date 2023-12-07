<?php

$file = file_get_contents('input.txt');

// break into lines
$lines = explode("\n", $file);
$maps = [];
$list = [];
$mapStarted = '';

foreach ($lines as $key => $line) {
    if ($line === '') {
        $mapStarted = '';
        continue;
    }

    //if $line contains seeds: then it is a list
    if (strpos($line, 'seeds:') !== false) {
        $parts = explode(":", $line);
        $seedList = explode(" ", $parts[1]);
        $list = array_values(array_filter($seedList));
        // loop over 2 items at a time
    }
    // if $line contains map then it is a map
    if (strpos($line, 'map:') !== false) {
        $parts = explode(" ", $line);
        $type = $parts[0];
        $mapStarted = $type;
        $maps[$type] = [];
    }

    if ($mapStarted !== '' && strpos($line, 'map:') === false && strpos($line, 'seeds:') === false) {
        $lineParts = explode(" ", $line);

        $destination = $lineParts[0];
        $source = $lineParts[1];
        $length = $lineParts[2];
        $maps[$mapStarted][] = [
            'source' => $source,
            'destination' => $destination,
            'length' => $length,
        ];
    }
}

$locationMap = [
    'seed-to-soil',
    'soil-to-fertilizer',
    'fertilizer-to-water',
    'water-to-light',
    'light-to-temperature',
    'temperature-to-humidity',
    'humidity-to-location',
];

// max int value
$minlocation = 2147483647;

foreach ($list as $value) {
        foreach ($locationMap as $map) {
            $itemLocation = 0;
            if ($map == 'humidity-to-location') {
                foreach ($maps[$map] as $mapItem) {
                    if ($value >= $mapItem['source'] && $value < ($mapItem['source'] + ($mapItem['length']))) {
                        $diff = $value - ($mapItem['source']);
                        $itemLocation = $mapItem['destination'] + $diff;
                        break;
                    }
                }
                if ($itemLocation !== 0) {
                    if ($itemLocation < $minlocation) {
                        $minlocation = $itemLocation;
                    }
                } else {
                    if ($value < $minlocation) {
                        $minlocation = $value;
                    }
                }
                continue;
            }
            foreach ($maps[$map] as $mapItem) {
                if ($value >= $mapItem['source'] && $value < ($mapItem['source'] + ($mapItem['length']))) {
                    $diff = $value - ($mapItem['source']);
                    $itemLocation = $mapItem['destination'] + $diff;
                    break;
                }
            }
            if ($itemLocation !== 0) {
                $value = (int)$itemLocation;
            } else {
                $value = (int)$value;
            }
        }
    
}

// sort the array by value
echo "min: " . $minlocation . "\n";
