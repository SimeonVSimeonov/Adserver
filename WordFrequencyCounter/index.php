<?php

// Store word frequency count in a global variable
$wordFrequency = [];

// POST Request Handler: Handles incoming text and counts word frequency
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputText = $_POST['text'] ?? '';

    // Normalize the text: Convert to lowercase, remove non-alphanumeric characters, and split by spaces
    $words = preg_split('/\s+/', strtolower(preg_replace('/[^a-z0-9\s]/i', '', $inputText)));

    // Count the frequency of each word
    foreach ($words as $word) {
        if (!empty($word)) {
            if (isset($GLOBALS['wordFrequency'][$word])) {
                $GLOBALS['wordFrequency'][$word]++;
            } else {
                $GLOBALS['wordFrequency'][$word] = 1;
            }
        }
    }

    echo 'Text processed successfully.';
}

// GET Request Handler for displaying all words and their counts
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['word'])) {
    echo "Word Frequency Counts:\n";
    foreach ($GLOBALS['wordFrequency'] as $word => $count) {
        echo "fooo\n";
        echo "$word : $count\n";
    }
}

// GET Request Handler for displaying the count of a specific word
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['word'])) {
    $searchWord = strtolower($_GET['word']);
    $count = isset($GLOBALS['wordFrequency'][$searchWord]) ? $GLOBALS['wordFrequency'][$searchWord] : 0;
    echo "The word '$searchWord' appeared $count times.\n";
}

