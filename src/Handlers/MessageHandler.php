<?php declare(strict_types=1);


namespace Eth\Handlers;


use Eth\CexHub;
use StdClass;

interface MessageHandler
{
    /**
     * @param StdClass $message
     * @return bool
     */
    public function handle(StdClass $message): bool;

    /**
     * @param CexHub $hub
     */
    public function setHub(CexHub $hub);
}