<?php


namespace Eth\Reactions;


use StdClass;

class Reconnect extends BaseReaction
{

    /**
     * @param StdClass $message
     * @return bool
     */
    public function handle(StdClass $message): bool
    {
        $this->hub->connect();
        return true;
    }
}