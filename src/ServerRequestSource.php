<?php

declare(strict_types=1);

namespace DelOlmo\Valinor\Mapper\Source;

use ArrayObject;
use IteratorAggregate;
use Override;
use Psr\Http\Message\ServerRequestInterface;
use Traversable;

use function array_merge;
use function is_array;

/** @implements IteratorAggregate<string, mixed> */
final class ServerRequestSource implements IteratorAggregate
{
    public function __construct(
        private readonly ServerRequestInterface $serverRequest,
    ) {
    }

    /** @return Traversable<string, mixed> */
    #[Override]
    public function getIterator(): Traversable
    {
        $attributes = $this->serverRequest->getAttributes();

        $queryParams = $this->serverRequest->getQueryParams();

        $parameters = array_merge($queryParams, $attributes);

        $parsedBody = $this->serverRequest->getParsedBody();

        if (! is_array($parsedBody)) {
            return new ArrayObject($parameters);
        }

        $array = array_merge($parsedBody, $parameters);

        return new ArrayObject($array);
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->serverRequest;
    }
}
