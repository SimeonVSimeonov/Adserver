# Word Frequency Counter Service

This is a simple PHP script that handles multiple POST requests with text and counts how often each word appears. It can also handle GET requests to display the word counts and search for specific words.

## Requirements

- PHP 7.x or later

## How to Execute the Program

1. **Create a folder** for your project (e.g., `word-frequency-counter`).

## How to Test the Program

### 1. Send a POST request to count words

You can send a POST request to the server to process the text and count the word frequency. For example, using cURL:

```bash
curl -X POST -d "text=Love grows where kindness lives." http://localhost/index.php
