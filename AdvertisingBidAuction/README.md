# Advertising Bid Auction

This project includes a command-line PHP solution to determine the best and second-best bids from a CSV file containing ad bid data.

## Requirements

- PHP version 7.4 or higher.
- Command-line access to run PHP scripts.
- A CSV file with the following columns:
    - `ad_id` (the ID of the ad)
    - `bid` (the bid value for the ad)
- There are some test .csv files in the repository.
## Files

### 1. `AdBidAuction.php`
This script reads a CSV file, processes the bids, and returns the best offer to win with the prize of the second-best bid.
If there are two or more equal highest bids, you can pass the [asc|desc] optional parameter to tell the program which bid you want,
the last or the first bid. The default behavior is the first bid. With a prize from the second best.

### 2. `DataGenerator.php`
This script can generate a large data set in .csv format for testing purposes.

### Usage

#### Test with simple data

```bash
php AdBidAuction.php <TestCase.csv>
```

#### Test with invalid data

```bash
php AdBidAuction.php <InvalidDataCase.csv>
```
#### Test with two or more equal highest bids data

```bash
php AdBidAuction.php <EdgeCase.csv> [asc|desc]
```

#### To test with a large set of data

```bash
php DataGenerator.php
php AdBidAuction.php <TenKRowsCase.csv> 
```