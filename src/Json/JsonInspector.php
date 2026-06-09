<?php

declare(strict_types=1);

namespace Behatch\Json;

use Exception;
use JsonSchema\SchemaStorage;
use JsonSchema\Uri\UriRetriever;
use JsonSchema\Uri\UriResolver;
use JsonSchema\Validator;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class JsonInspector
{
    private readonly PropertyAccessor $accessor;

    public function __construct(private $evaluationMode)
    {
        $this->accessor = new PropertyAccessor(0, PropertyAccessor::THROW_ON_INVALID_INDEX | PropertyAccessor::THROW_ON_INVALID_PROPERTY_PATH);
    }

    public function evaluate(Json $json, $expression)
    {
        if ($this->evaluationMode === 'javascript') {
            $expression = str_replace('->', '.', $expression);
        }

        try {
            return $json->read($expression, $this->accessor);
        } catch (Exception) {
            throw new Exception("Failed to evaluate expression '$expression'");
        }
    }

    public function validate(Json $json, JsonSchema $schema): bool
    {
        $validator = new Validator();

        $resolver = new SchemaStorage(new UriRetriever, new UriResolver);
        $schema->resolve($resolver);

        return $schema->validate($json, $validator);
    }
}
