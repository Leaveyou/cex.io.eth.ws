<?php

namespace Eth\Handlers;

use StdClass;

class Auth extends BaseHandler
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $secret;

    /**
     * Auth constructor.
     * @param string $key
     * @param string $secret
     */
    public function __construct(string $key, string $secret)
    {
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