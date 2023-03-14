<?php

declare(strict_types=1);

namespace DelOlmo\Valinor\Mapper\Source;

use ArrayObject;
use IteratorAggregate;
use Psr\Http\Message\ServerRequestInterface;
use Traversable;

use function array_merge;
use function is_array;

/** @implements IteratorAggregate<string, mixed> */
final class ServerRequestSource implements IteratorAggregate
{
    public function __construct(
        private ServerRequestInterface $request,
    ) {
    }

    /** @return Traversable<string, mixed> */
    public function getIterator(): Traversable
    {
        $attributes = $this->getRequest()->getAttributes();

        $queryParams = $this->getRequest()->getQueryParams();

        $parameters = array_merge($queryParams, $attributes);

        $parsedBody = $this->getRequest()->getParsedBody();

        if (! is_array($parsedBody)) {
            return new ArrayObject($parameters);
        }

        $array = array_merge($parsedBody, $parameters);

        return new ArrayObject($array);
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }
}
