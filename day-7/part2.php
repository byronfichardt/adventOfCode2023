<?php

$cardValues = 'J23456789TJQKA';

$file = file_get_contents('input.txt');

$hands = [];
$lines = explode("\n", $file);
foreach ($lines as $line) {
    $line = explode(' ', $line);
    $hand = $line[0];
    $bid = $line[1];
    $cards = str_split($hand);
    $cardranks = array_map(function($card) use ($cardValues) {
        return strpos($cardValues, $card);
    }, $cards);
    $values = array_count_values($cards);
    arsort($values);

    $jokers = 0;
    foreach ($cards as $key => $card) {
        if ($card === 'J') {
            $jokers++;
        }
    }
    unset($values['J']);
    // get the first value
    $firstValue = array_key_first($values);
    // we add the jokers to the first value
    $values[$firstValue] += $jokers;
    
    $valuecount = count($values);
    // the higher the value count the lower the rank
    $rank  = 5 - $valuecount;

    $hands[] = new rankedHand($cards, $bid, max($values) * $rank, $cardranks);
}

//sort hands first by rank
usort($hands, function($a, $b) {
    return $a->rank <=> $b->rank;
});

// group the hands by value
$groupedHands = [];
foreach ($hands as $hand) {
    $groupedHands[$hand->rank][] = $hand;
}

$sortedHands = [];
foreach ($groupedHands as $group) {
    // sort by the first value in the cardValues array
    usort($group, function($a, $b) {
        // Compare values of cards one by one
        for ($i = 0; $i < 5; $i++) {
            if ($a->cardValues[$i] !== $b->cardValues[$i]) {
                return $a->cardValues[$i] <=> $b->cardValues[$i];
            }
        }
        return 0; // If all values are equal, the cards are considered equal
    });

    $sortedHands = array_merge($sortedHands, $group);
}

$totalWinnings = 0;
foreach ($sortedHands as $key => $hand) {
    $totalWinnings += $hand->bid * ($key + 1);
}

echo ($totalWinnings);

class rankedHand {
    public function __construct(
        public array $cards,
        public int $bid,
        public int $rank,
        public array $cardValues
    ) {
    }
}
