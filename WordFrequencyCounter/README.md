
# Word Frequency Counter Service

This PHP service processes POST requests containing text and counts the frequency of each word. It also supports GET requests to display all word counts or search for specific words.

## Prerequisites

- Docker installed on your machine

## Setup & Running the Service

1. **Build the Docker container**:
    ```bash
    docker-compose build
    ```

2. **Run the service**:
    ```bash
    docker-compose up
    ```

3. **Shut down the service**:
    ```bash
    docker-compose down
    ```

## Testing the Service

You can test the service using cURL or Postman with the following endpoints.

### 1. Send a POST request with text to count word frequency

Example using cURL:
```bash
curl -X POST -d "text=Love grows where kindness lives." "http://localhost:8080/index.php"
curl -X POST -d "text=Kindness lives in every heart." "http://localhost:8080/index.php"
```

### 2. View all word counts with a GET request

To get the frequency of all words processed so far, use:
```bash
curl "http://localhost:8080/index.php"
```

### 3. Search for a specific word frequency with a GET request

To search for the frequency of a specific word, e.g., "kindness":
```bash
curl "http://localhost:8080/index.php?word=kindness"
```

