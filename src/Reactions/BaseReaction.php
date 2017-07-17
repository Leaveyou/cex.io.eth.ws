<?php


namespace Eth\Reactions;


use Eth\CexHub;


abstract class BaseReaction implements Reaction
{
    /** @var CexHub */
    protected $hub;

    /** @param CexHub $hub */
    public function setHub(CexHub $hub)
    {
        $this->hub = $hub;
    }
}