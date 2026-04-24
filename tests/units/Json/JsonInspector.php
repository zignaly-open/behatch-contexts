<?php

namespace Behatch\Tests\Units\Json;

use atoum;
use Behatch\Json\Json;
use mock\Behatch\Json\JsonSchema;

class JsonInspector extends atoum
{
    public function test_evaluate(): void
    {
        $json = new Json('{ "foo": { "bar": "foobar" } }');
        $inspector = $this->newTestedInstance('php');
        $result = $inspector->evaluate($json, 'foo.bar');

        $this->string($result)
            ->isEqualTo('foobar');
    }

    public function test_evaluate_invalid(): void
    {
        $json = new Json('{}');
        $inspector = $this->newTestedInstance('php');

        $this->exception(function () use($json, $inspector): void {
            $inspector->evaluate($json, 'foo.bar');
        })
        ->hasMessage("Failed to evaluate expression 'foo.bar'");
    }

    public function test_evaluate_javascript_mode(): void
    {
        $json = new Json('{ "foo": { "bar": "foobar" } }');
        $inspector = $this->newTestedInstance('javascript');
        $result = $inspector->evaluate($json, 'foo->bar');

        $this->string($result)
            ->isEqualTo('foobar');
    }

    public function test_evaluate_php_mode(): void
    {
        $json = new Json('{ "foo": { "bar": "foobar" } }');
        $inspector = $this->newTestedInstance('php');
        $result = $inspector->evaluate($json, 'foo.bar');

        $this->string($result)
            ->isEqualTo('foobar');
    }

    public function test_validate(): void
    {
        $json = new Json('{ "foo": { "bar": "foobar" } }');
        $inspector = $this->newTestedInstance('php');
        $schema = new JsonSchema('{}');

        $result = $inspector->validate($json, $schema);

        $this->boolean($result)
            ->isEqualTo(true);
    }
}
