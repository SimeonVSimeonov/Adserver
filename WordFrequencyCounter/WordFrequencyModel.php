<?php

class WordFrequencyModel
{
    const FREQUENCY_FILE = '/var/www/word_frequencies.json';

    /**
     * Load word frequencies from the file
     *
     * @return array|mixed
     */
    public static function load()
    {
        if (file_exists(self::FREQUENCY_FILE)) {
            $data = file_get_contents(self::FREQUENCY_FILE);
            return json_decode($data, true) ?: []; // Return empty array if data is invalid
        }
        return [];
    }

    /**
     * Save word frequencies to the file
     *
     * @param array $wordFrequency
     * @return void
     */
    public static function save(array $wordFrequency): void
    {
        file_put_contents(self::FREQUENCY_FILE, json_encode($wordFrequency, JSON_PRETTY_PRINT));
    }
}