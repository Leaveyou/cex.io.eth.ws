<?php


namespace Eth;


use Eth\Reactions\Reaction as ReactionInterface;
use Exception;
use Monolog\Logger;
use StdClass;
use WebSocket\Client;

class CexHub
{
    /** @var Client */
    protected $client;

    /** @var ReactionInterface[][] */
    protected $handlers = [];

    /** @var Logger  */
    protected $logger;


    /**
     * CexHub constructor.
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;

        $this->connect();
    }


    /**
     * @param StdClass $response
     * @throws Exception
     */
    public function react(StdClass $response)
    {
        $type = $response->e;
        $this->logger->debug("Received {$type}", (array)$response);

        if (!isset($this->handlers[$type])) {
            throw new Exception("Cannot handle message type: " . $type);
        }

        foreach ($this->handlers[$type] as $handler) {
            $this->logger->debug('          - Responding with "' . get_class($handler) . '"');
            $handler->handle($response);
        }
        $this->logger->debug('---');
    }


    public function receive(): StdClass
    {
        try {
            $rawData = $this->client->receive();
            $data = json_decode($rawData);
            if ($data === null) {
                $jsonErrorMessage = json_last_error_msg();
                throw new \Exception("$jsonErrorMessage");
            }
        } catch (Exception $e) {
            $data = (object)[
                "e"       => "timeout",
                "message" => "{$e->getMessage()}",
            ];
        }

        return $data;
    }

    /**
     * @param StdClass $data
     * @return bool
     */
    public function pushBack(StdClass $data): bool
    {
        $payload = json_encode($data);
        $this->client->send($payload);

        return true;
    }


    /**
     * Registers a handler for a particular event type
     * @param string            $type
     * @param ReactionInterface $handler
     */
    public function registerReaction(string $type, ReactionInterface $handler)
    {
        $handler->setHub($this);
        $this->handlers[$type][] = $handler;
    }

    public function connect()
    {
        $this->client = new Client("wss://ws.cex.io/ws/");

        // we should get at least a "PING" message every 15 seconds
        $this->client->setTimeout(16);
    }
}
