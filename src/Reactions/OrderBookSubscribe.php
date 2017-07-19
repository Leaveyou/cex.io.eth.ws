<?php


namespace Eth\Reactions;


use StdClass;

class OrderBookSubscribe extends BaseReaction
{

    /**
     * @param StdClass $message
     * @return bool
     */
    public function handle(StdClass $message): bool
    {
        $this->hub->pushBack(
            (object)[
                "e"    => "order-book-subscribe",
                "data" => [
                    "pair"      => [
                        "ETH",
                        "USD",
                    ],
                    "subscribe" => true,
                    "depth"     => -1,
                ],
                "oid"  => "order-book-subscribe-1",
            ]
        );

        return true;
    }
}