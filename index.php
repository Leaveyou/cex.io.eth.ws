<?php

include(dirname(__FILE__) . "/bootstrap.php");

use Eth\CexHub;
use Eth\Reactions\Auth as AuthReaction;
use Eth\Reactions\Nop as NopReaction;
use Eth\Reactions\Pong as PongReaction;
use Monolog\Logger;

// logger
$logger = new Logger("Output");
$streamHandler = new \Monolog\Handler\StreamHandler("php://output");
$logger->pushHandler($streamHandler);


$client = new CexHub($logger);


// auth handler
$key = "aLDpsI8eOQNFs0PqkvJhUjUO04";
$secret = "A3M4Sza2BOt4VnqDSRpRSolJI";
$authReaction = new AuthReaction($key, $secret);

// nop handler
$nopReaction = new NopReaction();

// ping handler
$pongReaction = new PongReaction();


$client->registerReaction("ping", $pongReaction);
$client->registerReaction("auth", $nopReaction);
$client->registerReaction("connected", $nopReaction);
$client->registerReaction("disconnecting", $nopReaction);


while ($action = $client->receive()) {
    $client->react($action);
}


echo PHP_EOL;
