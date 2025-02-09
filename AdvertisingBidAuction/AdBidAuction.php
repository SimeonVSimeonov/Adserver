<?php

function validateInput($argc, $argv) {
    if ($argc < 2 || $argc > 3) {
        echo "Usage: php AdBidAuction.php <file.csv> [asc|desc]\n";
        exit(1);
    }
    return [$argv[1], $argv[2] ?? 'asc'];
}

function readCSVFile($filename) {
    if (!file_exists($filename) || !is_readable($filename)) {
        echo "Error: File does not exist or is not readable.\n";
        exit(1);
    }

    $handle = fopen($filename, "r");
    if (!$handle) {
        echo "Error: Unable to open file.\n";
        exit(1);
    }

    $bids = [];
    while (($data = fgetcsv($handle)) !== false) {
        if (count($data) < 2) {
            continue;
        }

        $ad_id = trim($data[0]);
        $bid = trim($data[1]);

        if (!ctype_digit($ad_id) || !is_numeric($bid)) {
            continue;
        }

        $bids[intval($ad_id)] = floatval($bid);
    }
    fclose($handle);

    return $bids;
}

function processBids($bids, $sort_order) {
    if (count($bids) < 2) {
        echo "Error: Not enough valid bids.\n";
        exit(1);
    }

    uksort($bids, function ($a, $b) use ($bids) {
        if ($bids[$a] === $bids[$b]) {
            return $a <=> $b;
        }
        return $bids[$b] <=> $bids[$a];
    });

    $unique_bids = array_unique(array_values($bids));
    rsort($unique_bids);

    $best_bid = $unique_bids[0] ?? null;
    $second_best_bid = $unique_bids[1] ?? null;

    if ($second_best_bid === null) {
        echo "Error: No second-best bid found.\n";
        exit(1);
    }

    $top_ads = array_keys($bids, $best_bid);
    $best_ad_id = ($sort_order === 'asc') ? reset($top_ads) : end($top_ads);

    return [$best_ad_id, $second_best_bid];
}

// Main Execution
list($filename, $sort_order) = validateInput($argc, $argv);
$bids = readCSVFile($filename);
list($best_ad_id, $second_best_bid) = processBids($bids, $sort_order);

echo "$best_ad_id, $second_best_bid\n";
