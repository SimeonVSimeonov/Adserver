<?php

$file = "TenKRowsCase.csv";
$row_count = 10000;

$handle = fopen($file, "w");

for ($i = 1; $i <= $row_count; $i++) {
    $bid = mt_rand(1, 10000) / 100; // Random bid between 0.01 - 100.00

    // Introduce invalid data in 5% of cases
    if (mt_rand(1, 100) <= 5) {
        $invalid_cases = [
            ["", $bid],      // Missing ad_id
            [$i, "abc"],     // Non-numeric bid
            ["xyz", $bid],   // Non-numeric ad_id
            [$i, ""],        // Missing bid
            ["", ""]         // Empty row
        ];
        $row = $invalid_cases[array_rand($invalid_cases)];
    } else {
        $row = [$i, number_format($bid, 2, '.', '')]; // Valid data
    }

    fputcsv($handle, $row);
}

fclose($handle);

echo "Generated test file: $file with $row_count rows (including invalid data).\n";
