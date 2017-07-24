<?php


namespace Eth;


use Redis;

/**
 * @method void foo()
 */
class RedisClient
{
    /**
     * @var Redis
     */
    protected $connection;

    /**
     * RedisClient constructor.
     * @param Redis $connection
     */
    public function __construct(Redis $connection)
    {
        $this->connection = $connection;
    }


    /**
     * Connect to server without sending any commands
     */
    public function forceConnect()
    {
        $this->connect();
    }

    /**
     * Connect to redis server.
     */
    protected function connect()
    {
        $this->connection->connect("127.0.0.1", 6379, 1, null, 100);
    }
}