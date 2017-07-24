<?php


namespace Eth\Reactions;


use Eth\RedisClient;
use Monolog\Logger;
use StdClass;

class StoreMarketDepth extends BaseReaction
{
    /**
     * @var RedisClient
     */
    protected $redisClient;

    /**
     * StoreMarketDepth constructor.
     * @param Logger      $logger
     * @param RedisClient $redisClient
     */
    public function __construct(Logger $logger, RedisClient $redisClient)
    {
        parent::__construct($logger);
        $this->redisClient = $redisClient;
    }

    /**
     * @param StdClass $message
     * @return bool
     */
    public function handle(StdClass $message): bool
    {
        $this->redisClient;
        return true;
    }

}