<?php

declare(strict_types=1);

namespace Behatch\Tests\Units\Json;

use atoum;
use JsonSchema\SchemaStorage;
use JsonSchema\Uri\UriRetriever;
use JsonSchema\Uri\UriResolver;
use Behatch\Json\Json;
use JsonSchema\Validator;

class JsonSchema extends atoum
{
    public function test_resolve_without_uri(): void
    {
        $schema = $this->newTestedInstance('{}');
        $resolver = new SchemaStorage(new UriRetriever, new UriResolver);
        $schema->resolve($resolver);
    }

    public function test_resolve_with_uri(): void
    {
        $file = 'file://' . __DIR__ . '/../../fixtures/files/schema.json';
        $schema = (object)['id' => $file];
        $resolver = new SchemaStorage(new UriRetriever, new UriResolver);
        $result = $resolver->resolveRef($file);

        $this->object($result)
            ->isEqualTo($schema);
    }

    public function test_validate(): void
    {
        $schema = $this->newTestedInstance('{}');
        $json = new Json('{}');
        $validator = new Validator();
        $result = $schema->validate($json, $validator);

        $this->boolean($result)
            ->isTrue();
    }

    public function test_validate_invalid(): void
    {
        $schema = $this->newTestedInstance('{ "type": "object", "properties": {}, "additionalProperties": false }');
        $json = new Json('{ "foo": { "bar": "foobar" } }');
        $validator = new Validator();
        $this->exception(function () use($schema, $json, $validator): void {
            $schema->validate($json, $validator);
        })
        ->hasMessage(<<<EOD
JSON does not validate. Violations:
  - [] The property foo is not defined and the definition does not allow additional properties

EOD
        );
    }
}
