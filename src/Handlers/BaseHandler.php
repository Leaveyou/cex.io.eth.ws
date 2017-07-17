<?php


namespace Eth\Handlers;


use Eth\CexHub;


abstract class BaseHandler implements MessageHandler
{
    /** @var CexHub */
    protected $hub;

    /** @param CexHub $hub */
    public function setHub(CexHub $hub)
    {
        $this->hub = $hub;
    }
}