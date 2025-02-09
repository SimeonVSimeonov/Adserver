<?php

if ($argc < 2 || $argc > 3) {
    echo "Usage: php AdBidAuction.php <*.csv> [asc|desc]\n";
    exit(1);
}

$filename = $argv[1];
$sort_order = $argv[2] ?? 'asc'; // Default to ascending order

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
        continue; // Skip invalid rows
    }

    $ad_id = trim($data[0]);
    $bid = trim($data[1]);

    // Validate ad_id (must be numeric and not empty)
    if (!ctype_digit($ad_id)) {
        continue;
    }
    $ad_id = intval($ad_id);

    // Validate bid (must be a numeric value)
    if (!is_numeric($bid)) {
        continue;
    }
    $bid = floatval($bid);

    $bids[$ad_id] = $bid;
}

fclose($handle);

if (count($bids) < 2) {
    echo "Error: Not enough valid bids.\n";
    exit(1);
}

// Sort bids descending, then sort ad IDs ascending for consistency
uksort($bids, function ($a, $b) use ($bids) {
    if ($bids[$a] === $bids[$b]) {
        return $a <=> $b; // Sort by ad_id ascending if bids are equal
    }
    return $bids[$b] <=> $bids[$a]; // Sort by bid descending
});

// Get unique bid values sorted in descending order
$unique_bids = array_unique(array_values($bids));
rsort($unique_bids); // Ensure sorting is descending

$best_bid = $unique_bids[0] ?? null; // Highest bid
$second_best_bid = $unique_bids[1] ?? null; // Second highest bid

if ($second_best_bid === null) {
    echo "Error: No second-best bid found.\n";
    exit(1);
}

// Get all ads with the highest bid
$top_ads = array_keys($bids, $best_bid);

// Select first or last based on sorting preference
$best_ad_id = ($sort_order === 'asc') ? reset($top_ads) : end($top_ads);

echo "$best_ad_id, $second_best_bid\n";
