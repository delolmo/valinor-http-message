The following library allows using `ServerRequestInterface` objects of the [psr/http-message](https://github.com/php-fig/http-message) library as a source for the [cuyz/valinor](https://github.com/cuyz/valinor) library.

## Installation

```bash
composer require delolmo/valinor-http-message
```

## Example

```php

use App\DTO\CustomObject;
use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\MapperBuilder;
use DelOlmo\Valinor\Mapping\Source\ServerRequestSource;
use Psr\Http\Message\ServerRequestInterface;

final class CustomController
{
    public function execute(ServerRequestInterface $request)
    {
        // Create the Source using the new InputSource
        $source = Source::iterable(new ServerRequestSource($input));
        
        // Create the Mapper, using the desired configuration
        $mapper = new MapperBuilder())
            ->allowSuperfluousKeys()
            ->enableFlexibleCasting()
            ->mapper();
            
        // Map the source to whatever object makes sense
        $mapped = $mapper->map(CustomObject::class, $source);
        
        // Apply whatever business logic makes sense from here
        // ...
    }
}
```

## Final notes

- Versioning of `delolmo/valinor-console` will always match `cuyz/valinor` versions. Same goes for PHP versions.
- Although query params and body params should not share the same name in the Request, it should be noted that, from a ServerRequestSource standpoint, query params always take precedence over body params. That is, if there is a query param and a body param sharing the same name, ServerRequestSource will only use the query param's value for mapping purposes.
- Considering that many query and body params are retrieved as strings or arrays, it is interesting to note that `enableFlexibleCasting` should also be configured in the Mapper. See [Enabling flexible casting](https://valinor.cuyz.io/latest/mapping/type-strictness/#enabling-flexible-casting) for more information.
