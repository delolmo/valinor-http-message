# delolmo/valinor-http-message

[![Packagist Version](https://img.shields.io/packagist/v/delolmo/valinor-http-message.svg?style=flat-square)](https://packagist.org/packages/delolmo/valinor-http-message)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

Use a [PSR-7](https://www.php-fig.org/psr/psr-7/) `ServerRequestInterface` as a source for the [cuyz/valinor](https://github.com/cuyz/valinor) mapper.

## Requirements

* PHP ~8.4.27 || ^8.5.12
* cuyz/valinor ^2.6

## Installation

```sh
composer require delolmo/valinor-http-message
```

## Example

```php
use App\DTO\CustomObject;
use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\MapperBuilder;
use DelOlmo\Valinor\Mapper\Source\ServerRequestSource;
use Psr\Http\Message\ServerRequestInterface;

final class CustomController
{
    public function execute(ServerRequestInterface $request)
    {
        // Create the source from the request
        $source = Source::iterable(new ServerRequestSource($request));

        // Create the mapper, using the desired configuration
        $mapper = new MapperBuilder()
            ->allowSuperfluousKeys()
            ->allowScalarValueCasting()
            ->mapper();

        // Map the source to whatever object makes sense
        $mapped = $mapper->map(CustomObject::class, $source);

        // Apply whatever business logic makes sense from here
        // ...
    }
}
```

## What the source holds

The source merges three parts of the request. When they share a key, the later one wins:

1. the parsed body (`getParsedBody()`), when it is an array;
2. the query params (`getQueryParams()`);
3. the attributes (`getAttributes()`), such as route parameters a router stored.

A parsed body that is `null` or an object is left out, and so are uploaded files.

## Final notes

- Major versions of `delolmo/valinor-http-message` follow the major versions of `cuyz/valinor`.
- Query and body params mostly arrive as strings, so the mapper usually needs `allowScalarValueCasting()`. See the [Valinor documentation](https://valinor.cuyz.io/latest/) on type strictness.
- A request usually carries more than the target object needs (attributes stored by middlewares, for one), so the mapper usually needs `allowSuperfluousKeys()` too.
