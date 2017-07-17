<?php


namespace Eth\Reactions;


use StdClass;

class GetOpenPositions extends BaseReaction
{

    /**
     * @param StdClass $message
     * @return bool
     */
    public function handle(StdClass $message): bool
    {
        $payload = (object)[
            "e"    => "open-positions",
            "data" => [
                "pair" => ["ETH", "USD"],
            ],
        ];

        return $this->hub->pushBack($payload);
    }
}