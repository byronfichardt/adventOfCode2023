<?php

$file = file_get_contents('input.txt');

//get lines
$lines = explode("\n", $file);

$times = str_replace('Time:', '',$lines[0]);
$times = explode(' ', $times);
$time = implode('', $times);
$distances = str_replace('Distance:','', $lines[1]);
$distances = explode(' ', $distances);
$distance = implode('', $distances);

$race = new Race($time, $distance);

$raceOptions = [];
$racewinningscount = 0;
for ($i = 1; $i < $race->time; $i++) {
    $distancetraveled = ($race->time - $i) * $i;
    if ($race->distance < $distancetraveled) {
        $racewinningscount += 1;
    } 
}

echo $racewinningscount;

class race {
    public function __construct(
        public int $time,
        public int $distance,
    ){}
}