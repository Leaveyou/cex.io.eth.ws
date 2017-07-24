<?php

include(dirname(__FILE__) . "/bootstrap.php");

use Eth\CexHub;
use Eth\Reactions\Auth as AuthReaction;
use Eth\Reactions\Nop as NopReaction;
use Eth\Reactions\Pong as PongReaction;
use Eth\Reactions\Log as LogReaction;
use Eth\Reactions\Reconnect as ReconnectReaction;
use Eth\Reactions\GetOpenPositions as GetPositionsReaction;
use Eth\Reactions\OrderBookSubscribe as OrderBookSubscribeReaction;
use Eth\Reactions\StoreMarketDepth as StoreMarketDepthReaction;
use Eth\RedisClient;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

// todo: handle incorrect login or token

/** Application logger */
$logger = new Logger("Output");
$streamHandler = new StreamHandler("php://output");
$logger->pushHandler($streamHandler);

/** Redis connection and client */
$redisServer = new Redis();
$redisClient = new RedisClient($redisServer);

/** Main application */
$client = new CexHub($logger);

$key = "_##_##_##_##_##_##_##_";
$secret = "_##_##_##_##_##_##_##_";


/**
 * Defining reactions
 * Reactions are handlers for occurring events.
 */

$authReaction             = new AuthReaction($logger, $key, $secret);            // Authentication reaction
$getOpenPositionsReaction = new GetPositionsReaction($logger, "EUR", "USD"); // Get your open positions reaction
$nopReaction              = new NopReaction($logger);                            // No operation reaction - does nothing
$pongReaction             = new PongReaction($logger);                           // Pong reaction - Responds to "ping"
$LogReaction              = new LogReaction($logger);                            // Logs data and does nothing else
$reconnectReaction        = new ReconnectReaction($logger);                      // Reconnects to websocket
$subscribeReaction        = new OrderBookSubscribeReaction($logger);             // Subscribe to order book updates
$storeMarketDepthReaction = new StoreMarketDepthReaction($logger, $redisClient); // Stores market sell/buy orders into redis


/**
 * Registering reactions
 *
 * You can register multiple reactions for an event type.
 * They will all run in the order they were defined.
 *
 * The available cex.io websocket api events are available at
 * https://cex.io/websocket-api#private-channels
 *
 */


/** Mandatory reactions */
$client->registerReaction("connected",            $authReaction);             // After confirmed connection, authenticate
$client->registerReaction("timeout",              $reconnectReaction);        // Custom event triggered when remote is down

$client->registerReaction("ping",                 $pongReaction);             // Respond to PING with PONG
$client->registerReaction("disconnecting",        $nopReaction);              // React to "disconnecting" message that occurs ONLY when failing to reply to pings

/** After confirmed authentication */
$client->registerReaction("auth",                 $getOpenPositionsReaction); // Get open positions (margin trading)
$client->registerReaction("auth",                 $subscribeReaction);        // Subscribe to Order book updates (market buy/sell orders and volumes)




$client->registerReaction("open-positions",       $LogReaction);              // Single response to GetOpenPositions reaction::class

$client->registerReaction("balance",              $LogReaction);              // describe

$client->registerReaction("order",                $LogReaction);              // describe

$client->registerReaction("obalance",             $LogReaction);              // describe

$client->registerReaction("tx",                   $LogReaction);              // describe


$client->registerReaction("md_update",            $LogReaction);              // describe
$client->registerReaction("md_update",            $storeMarketDepthReaction); // describe

$client->registerReaction("order-book-subscribe", $LogReaction);              // describe


/**
 * Run the application
 * The application flow is basically an infinite loop
 */
try {
    // infinite loop
    while (1) {
        $action = $client->receive();
        $client->react($action);
    }
} catch (\Throwable $e) {
    $logger->error($e->getMessage());
}

