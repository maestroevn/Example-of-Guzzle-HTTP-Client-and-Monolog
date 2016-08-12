<?php
chdir(dirname(__DIR__));

require_once 'vendor/autoload.php';

$stack = \GuzzleHttp\HandlerStack::create();

$streamHandler = new \Monolog\Handler\StreamHandler('guzzle.log');

$logger = new \Monolog\Logger('logger');
$logger->pushHandler($streamHandler);

$messageFormatter = new \GuzzleHttp\MessageFormatter();

$guzzleMiddleware = \GuzzleHttp\Middleware::log($logger, $messageFormatter);

$stack->push($guzzleMiddleware);

$client = new \GuzzleHttp\Client(
    [
        'base_uri' => 'https://qrng.anu.edu.au',
        'handler' => $stack,
    ]
);

/** @var $response \GuzzleHttp\Psr7\Response */
$response = $client->get('/API/jsonI.php?length=7&type=uint8');

$body = $response->getBody();

$content = json_decode($body->getContents());

echo "<pre>";
print_r($content);
echo "</pre>";



