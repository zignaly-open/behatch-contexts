<?php

declare(strict_types=1);

namespace Behatch\HttpCall;

use Behatch\HttpCall\Request\BrowserKit;
use InvalidArgumentException;
use Behat\Mink\Mink;

class Request
{
    private ?BrowserKit $client = null;

    public function __construct(private readonly Mink $mink)
    {
    }

    public function __call(string $name, array $arguments): mixed
    {
        return call_user_func_array([$this->getClient(), $name], $arguments);
    }

    private function getClient(): BrowserKit
    {
        if (!$this->client instanceof BrowserKit) {
            if ($this->mink->getDefaultSessionName() === 'symfony2') {
                throw new InvalidArgumentException(
                    "The 'symfony2' session alias was removed in behatch/contexts 5.0 " .
                    "(fabpot/goutte is abandoned). Update your behat.yml to 'session: default' " .
                    "and use behat/mink-browserkit-driver."
                );
            }
            $this->client = new BrowserKit($this->mink);
        }

        return $this->client;
    }
}
