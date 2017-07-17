<?php


namespace Eth\Reactions;


use StdClass;

class Log extends BaseReaction
{

    /**
     * @param StdClass $message
     * @return bool
     */
    public function handle(StdClass $message): bool
    {
        //$data = json_decode($message);
        $this->logger->debug("\n" . print_r($message, true));
        return true;
    }
}