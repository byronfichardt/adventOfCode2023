<?php

$file = file_get_contents('input.txt');

// break into lines
$lines = explode("\n", $file);
$cards = [];
foreach ($lines as $key => $line) {
    // break into words
    $card = explode("|", $line);
    $winningNumbers = explode(":", $card[0]);
    $winningNumbers = $winningNumbers[1];
    $winningNumbers = explode(" ", $winningNumbers);
    // filter out empty values
    $winningNumbers = array_filter($winningNumbers);
    $cardNumbers = explode(" ", $card[1]);
    $cardNumbers = array_filter($cardNumbers);

    $matches = array_intersect($winningNumbers, $cardNumbers);
    
    $cards[] = new card($key, 1, count($matches));

}

foreach ($cards as $card) {
    for ($j = 0; $j < $card->count; $j++) {
        for ($i = 1; $i <= $card->matches; $i++) {
            if(!isset($cards[$card->id + $i])) {
                break;
            }
            $cards[$card->id + $i]->count += 1;
        }
    }   
}

// sum the counts
$sum = 0;
foreach ($cards as $card) {
    $sum += $card->count;
}

echo $sum . "\n";

class card {
    public function __construct(
        public int $id,
        public int $count,
        public int $matches
    ) {
    }
}