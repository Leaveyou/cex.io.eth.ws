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
        print_r((array)$message, false);
        //$this->logger->debug("\n" . print_r((array)$message, true));
        return true;
    }
}