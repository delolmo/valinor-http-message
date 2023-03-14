<?php

declare(strict_types=1);

namespace DelOlmo\Valinor\Mapper\Source;

use ArrayObject;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

final class ServerRequestSourceTest extends TestCase
{
    public function testGetRequest(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);

        $source = new ServerRequestSource($request);

        Assert::assertSame($request, $source->getRequest());
    }

    public function testGetIterator(): void
    {
        $queryParams = ['foo' => 'bar'];
        $parsedBody  = ['foo' => 'baz'];
        $attributes  = ['foo' => 'biz'];

        // Check attributes replace everything else
        $requestx1 = $this->createMock(ServerRequestInterface::class);
        $requestx1->method('getQueryParams')->willReturn($queryParams);
        $requestx1->method('getParsedBody')->willReturn($parsedBody);
        $requestx1->method('getAttributes')->willReturn($attributes);

        $sourcex1   = new ServerRequestSource($requestx1);
        $expectedx1 = new ArrayObject(['foo' => 'biz']);
        Assert::assertEquals($expectedx1, $sourcex1->getIterator());

        // Check query params replace parsedBody
        $requestx2 = $this->createMock(ServerRequestInterface::class);
        $requestx2->method('getQueryParams')->willReturn($queryParams);
        $requestx2->method('getParsedBody')->willReturn($parsedBody);
        $requestx2->method('getAttributes')->willReturn([]);

        $sourcex2   = new ServerRequestSource($requestx2);
        $expectedx2 = new ArrayObject(['foo' => 'bar']);
        Assert::assertEquals($expectedx2, $sourcex2->getIterator());

        // Check parsed body params are added correctly
        $requestx3 = $this->createMock(ServerRequestInterface::class);
        $requestx3->method('getQueryParams')->willReturn([]);
        $requestx3->method('getParsedBody')->willReturn($parsedBody);
        $requestx3->method('getAttributes')->willReturn([]);

        $sourcex3   = new ServerRequestSource($requestx3);
        $expectedx3 = new ArrayObject(['foo' => 'baz']);
        Assert::assertEquals($expectedx3, $sourcex3->getIterator());

        // Check parsed body is not added if it is not an array
        $requestx4 = $this->createMock(ServerRequestInterface::class);
        $requestx4->method('getQueryParams')->willReturn($queryParams);
        $requestx4->method('getParsedBody')->willReturn(null);
        $requestx4->method('getAttributes')->willReturn([]);

        $sourcex4   = new ServerRequestSource($requestx4);
        $expectedx4 = new ArrayObject(['foo' => 'bar']);
        Assert::assertEquals($expectedx4, $sourcex4->getIterator());
    }
}
