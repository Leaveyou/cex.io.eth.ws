<?php


namespace Eth\Reactions;


use Eth\Concepts\Currency;
use Monolog\Logger;
use StdClass;

class GetOpenPositions extends BaseReaction
{

    /**
     * @var Currency
     */
    protected $firstCurrency;
    /**
     * @var Currency
     */
    protected $secondCurrency;

    public function  __construct(Logger $logger, $firstCurrency, $secondCurrency)
    {
        parent::__construct($logger);

        $this->firstCurrency = $firstCurrency;
        $this->secondCurrency = $secondCurrency;
    }

    /**
     * @param StdClass $message
     * @return bool
     */
    public function handle(StdClass $message): bool
    {
        $payload = (object)[
            "e"    => "open-positions",
            "data" => [
                "pair" => [$this->firstCurrency, $this->secondCurrency],
            ],
        ];

        return $this->hub->pushBack($payload);
    }
}