<?php

class WordFrequencyService
{
    /**
     * Handle POST request: process the text and update word frequencies
     *
     * @param $text
     * @return string
     */
    public function handlePostRequest($text): string
    {
        if (empty($text)) {
            return "Error: No text provided.\n";
        }

        $words = $this->processText($text);
        $wordFrequency = WordFrequencyModel::load();

        $this->countWordFrequency($words, $wordFrequency);
        WordFrequencyModel::save($wordFrequency);

        return "Text processed successfully.\n";
    }

    /**
     * Handle GET request: show word counts or search for a specific word
     *
     * @param $searchWord
     * @return string
     */
    public function handleGetRequest($searchWord = null): string
    {
        $wordFrequency = WordFrequencyModel::load();

        // Search for a specific word frequency
        if ($searchWord) {
            $searchWord = strtolower($searchWord);
            $count = $wordFrequency[$searchWord] ?? 0;
            return "The word '$searchWord' appeared $count times.\n";
        }

        // Show all word frequencies if no specific word is provided
        $response = "Word Frequency Counts:\n";
        foreach ($wordFrequency as $word => $count) {
            $response .= "$word : $count\n";
        }
        return $response;
    }

    /**
     * Normalize and split text into words
     *
     * @param $text
     * @return array|false|string[]
     */
    private function processText($text)
    {
        // Normalize the text: convert to lowercase and remove non-alphanumeric characters
        $cleanedText = strtolower(preg_replace('/[^a-z0-9\s]/i', '', $text));
        return preg_split('/\s+/', $cleanedText);
    }

    /**
     * Count word frequencies from an array of words
     *
     * @param array $words
     * @param array $wordFrequency
     * @return void
     */
    private function countWordFrequency(array $words, array &$wordFrequency): void
    {
        foreach ($words as $word) {
            if (!empty($word)) {
                $wordFrequency[$word] = ($wordFrequency[$word] ?? 0) + 1;
            }
        }
    }
}