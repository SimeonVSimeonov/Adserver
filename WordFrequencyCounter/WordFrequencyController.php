<?php

class WordFrequencyController
{
    private WordFrequencyService $service;

    public function __construct()
    {
        $this->service = new WordFrequencyService();
    }

    /**
     * Handle POST request for word frequency processing
     *
     * @return void
     */
    public function post(): void
    {
        $inputText = $_POST['text'] ?? '';
        $response = $this->service->handlePostRequest($inputText);
        echo $response;
    }

    /**
     * Handle GET request for fetching word frequency counts or a specific word count
     *
     * @return void
     */
    public function get(): void
    {
        $searchWord = $_GET['word'] ?? null;
        $response = $this->service->handleGetRequest($searchWord);
        echo $response;
    }
}