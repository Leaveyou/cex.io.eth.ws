<?php


namespace Eth\Handlers;


use StdClass;

class Pong extends BaseHandler
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