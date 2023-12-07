<?php

$file = file_get_contents('input.txt');

//get lines
$lines = explode("\n", $file);

$times = str_replace('Time:', '',$lines[0]);
$times = explode(' ', $times);
$times = array_values(array_filter($times));
$distances = str_replace('Distance:','', $lines[1]);
$distances = explode(' ', $distances);
$distances = array_values(array_filter($distances));

$races = [];

foreach ($times as $key => $time) {
    $races[] = new Race($time, $distances[$key]);
}
$raceOptions = [];
foreach ($races as $race) {
    $racewinningscount = 0;
    for ($i = 1; $i < $race->time; $i++) {
        $distancetraveled = ($race->time - $i) * $i;
        if ($race->distance < $distancetraveled) {
            $racewinningscount += 1;
        } 
    }
    $raceOptions[] = $racewinningscount;
}

$sum = 1;
foreach ($raceOptions as $option) {
    $sum *= $option;
}

echo $sum;

class race {
    public function __construct(
        public int $time,
        public int $distance,
    ){}
}