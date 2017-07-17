<?php


namespace Eth\Reactions;


use Eth\CexHub;
use Monolog\Logger;

abstract class BaseReaction implements Reaction
{
    /** @var CexHub */
    protected $hub;

    /** @var Logger */
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /** @param CexHub $hub */
    public function setHub(CexHub $hub)
    {
        $this->hub = $hub;
    }
}