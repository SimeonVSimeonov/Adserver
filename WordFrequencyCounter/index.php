<?php

const HTTP_METHOD_POST = 'POST';
const HTTP_METHOD_GET = 'GET';

require_once 'WordFrequencyModel.php';
require_once 'WordFrequencyService.php';
require_once 'WordFrequencyController.php';

$controller = new WordFrequencyController();

switch ($_SERVER['REQUEST_METHOD']) {
    case HTTP_METHOD_GET:
        $controller->get();
        break;

    case HTTP_METHOD_POST:
        $controller->post();
        break;

    default:
        echo "Invalid request method.\n";
        break;
}