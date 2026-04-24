<?php

declare(strict_types=1);

namespace Behatch\HttpCall;

use Behat\Mink\Element\DocumentElement;

class RestContextVoter implements ContextSupportedVoter, FilterableHttpCallResult
{
    public function vote(HttpCallResult $httpCallResult): bool
    {
        return $httpCallResult->getValue() instanceof DocumentElement;
    }

    public function filter(HttpCallResult $httpCallResult)
    {
        return $httpCallResult->getValue()->getContent();
    }
}
