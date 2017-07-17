<?php declare(strict_types=1);


namespace Eth\Reactions;


use Eth\CexHub;
use StdClass;

interface Reaction
{
    /**
     * @param StdClass $message
     * @return bool
     */
    public function handle(StdClass $message): bool;

    /**
     * @param CexHub $hub
     */
    public function setHub(CexHub $hub);
}