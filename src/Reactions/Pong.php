<?php


namespace Eth\Reactions;


use StdClass;

class Pong extends BaseReaction
{
    /**
     * @param StdClass $message
     * @return bool
     */
    public function handle(StdClass $message): bool
    {
        $this->hub->pushBack((object)["e" => "pong"]);
        return true;
    }
}