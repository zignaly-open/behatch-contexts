<?php

declare(strict_types=1);

namespace Behatch\Context;

use Behatch\Html;
use Behatch\Asserter;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Context\TranslatableContext;
use Behat\MinkExtension\Context\RawMinkContext;

abstract class BaseContext extends RawMinkContext implements TranslatableContext
{
    use Html;
    use Asserter;

    public static function getTranslationResources()
    {
        return glob(__DIR__ . '/../../i18n/*.xliff');
    }

    /**
     * en
     * @transform /^(0|[1-9]\d*)(?:st|nd|rd|th)?$/
     *
     * fr
     * @transform /^(0|[1-9]\d*)(?:ier|er|e|ème)?$/
     *
     * pt
     * @transform /^(0|[1-9]\d*)º?$/
     *
     * ru
     * @transform /^(0|[1-9]\d*)(?:ой|ий|ый|ей|й)?$/
     */
    public function castToInt($count)
    {
        if (intval($count) < PHP_INT_MAX) {

            return intval($count);
        }

        return $count;
    }

    protected function getMinkContext()
    {
        $context = new MinkContext();
        $context->setMink($this->getMink());
        $context->setMinkParameters($this->getMinkParameters());

        return $context;
    }
}
