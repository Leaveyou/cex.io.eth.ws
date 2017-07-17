<?php

namespace Eth\Reactions;

use Monolog\Logger;
use StdClass;

class Auth extends BaseReaction
{
    /** @var string */
    protected $key;

    /** @var string */
    protected $secret;

    /**
     * Auth constructor.
     * @param Logger $logger
     * @param string $key
     * @param string $secret
     */
    public function __construct(Logger $logger, string $key, string $secret)
    {
        parent::__construct($logger);

        $this->key = $key;
        $this->secret = $secret;
    }

    /**
     * @param StdClass $message
     * @return bool
     */
    public function handle(StdClass $message): bool
    {
        $timestamp = time();
        $signature = hash_hmac("sha256", $timestamp . $this->key, $this->secret);

        $payload = (object)[
            "e"    => "auth",
            "auth" => [
                "key"       => $this->key,
                "signature" => $signature,
                "timestamp" => $timestamp,
            ],
        ];

        return $this->hub->pushBack($payload);
    }
}