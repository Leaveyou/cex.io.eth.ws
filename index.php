<?php

include(dirname(__FILE__) . "/bootstrap.php");

use Eth\CexHub;
use Eth\Reactions\Auth as AuthReaction;
use Eth\Reactions\Nop as NopReaction;
use Eth\Reactions\Pong as PongReaction;
use Eth\Reactions\Log as LogReaction;
use Eth\Reactions\GetOpenPositions as GetOpenPositionsReaction;
use Monolog\Logger;

// logger
$logger = new Logger("Output");
$streamHandler = new \Monolog\Handler\StreamHandler("php://output");
$logger->pushHandler($streamHandler);


$client = new CexHub($logger);


// auth reaction
$key = "aLDpsI8eOQNFs0PqkvJhUjUO04";
$secret = "A3M4Sza2BOt4VnqDSRpRSolJI";
$authReaction = new AuthReaction($logger, $key, $secret);
$getOpenPositionsReaction = new GetOpenPositionsReaction($logger);

// nop reaction
$nopReaction = new NopReaction($logger);

// ping reaction
$pongReaction = new PongReaction($logger);

// log reaction
$LogReaction = new LogReaction($logger);


$client->registerReaction("ping", $pongReaction);

$client->registerReaction("auth", $nopReaction);
$client->registerReaction("auth", $getOpenPositionsReaction);

$client->registerReaction("connected", $authReaction);

$client->registerReaction("open-positions", $LogReaction);

$client->registerReaction("disconnecting", $nopReaction);
$client->registerReaction("timeout", $authReaction);

try {
    // infinite loop
    while (1) {
        $action = $client->receive();
        $client->react($action);
    }
} catch (\Throwable $e) {
    $logger->error($e->getMessage());
}

