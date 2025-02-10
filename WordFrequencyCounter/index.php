<?php

// Define the path to the file where word frequencies are stored
const FREQUENCY_FILE = '/var/www/word_frequencies.json';

// Load the word frequencies from the file if it exists
$wordFrequency = [];
if (file_exists(FREQUENCY_FILE)) {
    $wordFrequency = json_decode(file_get_contents(FREQUENCY_FILE), true);
    if (!$wordFrequency) {
        $wordFrequency = []; // If there's a file, but it's corrupted or empty.
    }
}

// POST Request Handler: Handles incoming text and counts word frequency
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputText = $_POST['text'] ?? '';

    // Normalize the text: Convert to lowercase, remove non-alphanumeric characters, and split by spaces
    $words = preg_split('/\s+/', strtolower(preg_replace('/[^a-z0-9\s]/i', '', $inputText)));

    // Count the frequency of each word
    foreach ($words as $word) {
        if (!empty($word)) {
            if (isset($wordFrequency[$word])) {
                $wordFrequency[$word]++;
            } else {
                $wordFrequency[$word] = 1;
            }
        }
    }

    // Save the updated word frequencies back to the file
    file_put_contents(FREQUENCY_FILE, json_encode($wordFrequency));

    echo "Text processed successfully.\n";
}

// GET Request Handler for displaying all words and their counts
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['word'])) {
    echo "Word Frequency Counts:\n";
    foreach ($wordFrequency as $word => $count) {
        echo "$word : $count\n";
    }
}

// GET Request Handler for displaying the count of a specific word
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['word'])) {
    $searchWord = strtolower($_GET['word']);
    $count = $wordFrequency[$searchWord] ?? 0;
    echo "The word '$searchWord' appeared $count times.\n";
}
