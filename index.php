<?php

include(dirname(__FILE__) . "/bootstrap.php");

use Eth\CexHub;
use Eth\Handlers\Auth as AuthHandler;
use Eth\Handlers\Nop as NopHandler;
use Eth\Handlers\Pong as PongHandler;
use Monolog\Logger;

// logger
$logger = new Logger("Output");
$streamHandler = new \Monolog\Handler\StreamHandler("php://output");
$logger->pushHandler($streamHandler);


$client = new CexHub($logger);


// auth handler
$key = "aLDpsI8eOQNFs0PqkvJhUjUO04";
$secret = "A3M4Sza2BOt4VnqDSRpRSolJI";
$authHandler = new AuthHandler($key, $secret);

// nop handler
$nopHandler = new NopHandler();

// ping handler
$pongHandler = new PongHandler();


$client->registerHandler("ping", $pongHandler);
$client->registerHandler("auth", $nopHandler);
$client->registerHandler("connected", $nopHandler);
$client->registerHandler("disconnecting", $nopHandler);


while ($response = $client->receive()) {
    $client->handle($response);
}


echo PHP_EOL;