<?php


namespace Eth\Handlers;


use Eth\CexHub;
use StdClass;

class Nop extends BaseHandler
{
    /**
     * @param StdClass $message
     * @return bool
     */
    public function handle(StdClass $message): bool
    {
        return true;
    }

    /**
     * Override because we don't need the hub
     * @param CexHub $hub
     */
    public function setHub(CexHub $hub)
    {
        // I refuse the creator
    }
}
