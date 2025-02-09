<?php

if ($argc < 2 || $argc > 3) {
    echo "Usage: php auction.php <file.csv> [asc|desc]\n";
    exit(1);
}

$filename = $argv[1];
$sort_order = $argv[2] ?? 'desc'; // Default to 'desc' if not provided

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

// Sort by bid descending, then by ad ID ascending for consistency
uksort($bids, function ($a, $b) use ($bids) {
    if ($bids[$a] === $bids[$b]) {
        return $a <=> $b; // Sort by ad_id ascending if bids are equal
    }
    return $bids[$b] <=> $bids[$a]; // Sort by bid descending
});

// Get all ads with the highest bid
$max_bid = max($bids);
$top_ads = array_keys($bids, $max_bid);

// Select the first or last based on sorting preference
$best_ad_id = ($sort_order === 'asc') ? end($top_ads) : reset($top_ads);
$second_best_bid = array_values($bids)[1];

echo "$best_ad_id, $second_best_bid\n";
