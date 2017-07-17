<?php


namespace Eth;


use Eth\Handlers\MessageHandler as MessageHandlerInterface;
use Exception;
use Monolog\Logger;
use StdClass;
use WebSocket\Client;

class CexHub
{
    /** @var Client */
    protected $client;

    /** @var MessageHandlerInterface[][] */
    protected $handlers = [];

    /** @var Logger  */
    protected $logger;


    /**
     * CexHub constructor.
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->client = new Client("wss://ws.cex.io/ws/");
        $this->logger = $logger;

        // we should get at least a "PING" message every 15 seconds
        $this->client->setTimeout(16);
    }


    /**
     * @param StdClass $response
     * @throws Exception
     */
    public function handle(StdClass $response)
    {
        $type = $response->e;

        if (!isset($this->handlers[$type])) {
            throw new Exception("Cannot handle message type: " . $type . PHP_EOL . print_r($response, true));
        }

        foreach ($this->handlers[$type] as $handler) {
            $handler->handle($response);
        }
    }


    public function receive()
    {
        $rawData = $this->client->receive();
        $this->client->getCloseStatus();
        $rawData = json_decode($rawData);

        return $rawData;
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
     * @param string                  $type
     * @param MessageHandlerInterface $handler
     */
    public function registerHandler(string $type, MessageHandlerInterface $handler)
    {
        $handler->setHub($this);
        $this->handlers[$type][] = $handler;
    }
}

