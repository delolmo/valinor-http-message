<?php

declare(strict_types=1);

namespace DelOlmo\Valinor\Mapper\Source\Tests;

use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\MapperBuilder;
use DelOlmo\Valinor\Mapper\Source\ServerRequestSource;
use DelOlmo\Valinor\Mapper\Source\Tests\Fixtures\SearchQuery;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use stdClass;

use function iterator_to_array;

#[CoversClass(ServerRequestSource::class)]
final class ServerRequestSourceTest extends TestCase
{
    #[TestDox('getRequest() returns the request the source was built from')]
    public function testGetRequestReturnsTheWrappedRequest(): void
    {
        $request = new ServerRequest();

        $serverRequestSource = new ServerRequestSource($request);

        Assert::assertSame($request, $serverRequestSource->getRequest());
    }

    /**
     * @param array<string, mixed>             $queryParams
     * @param array<string, mixed>|object|null $parsedBody
     * @param array<string, int|string>        $attributes
     * @param array<string, mixed>             $expected
     */
    #[DataProvider('parameterProvider')]
    #[TestDox('getIterator() yields $_dataName')]
    public function testGetIteratorMergesRequestParameters(
        array $queryParams,
        array|object|null $parsedBody,
        array $attributes,
        array $expected,
    ): void {
        $request = new ServerRequest(queryParams: $queryParams, parsedBody: $parsedBody);

        foreach ($attributes as $name => $value) {
            $request = $request->withAttribute($name, $value);
        }

        $parameters = iterator_to_array(new ServerRequestSource($request));

        Assert::assertSame($expected, $parameters);
    }

    /**
     * @return iterable<string, array{
     *     array<string, mixed>,
     *     array<string, mixed>|object|null,
     *     array<string, int|string>,
     *     array<string, mixed>,
     * }>
     */
    public static function parameterProvider(): iterable
    {
        yield 'attributes over query params and parsed body' => [
            ['foo' => 'query'],
            ['foo' => 'body'],
            ['foo' => 'attribute'],
            ['foo' => 'attribute'],
        ];

        yield 'query params over the parsed body' => [
            ['foo' => 'query'],
            ['foo' => 'body'],
            [],
            ['foo' => 'query'],
        ];

        yield 'the keys of all three, body first' => [
            ['query' => 1],
            ['body' => 2],
            ['attribute' => 3],
            ['body' => 2, 'query' => 1, 'attribute' => 3],
        ];

        yield 'no parsed body when there is none' => [
            ['foo' => 'query'],
            null,
            ['bar' => 'attribute'],
            ['foo' => 'query', 'bar' => 'attribute'],
        ];

        yield 'no parsed body when it is an object' => [
            ['foo' => 'query'],
            new stdClass(),
            [],
            ['foo' => 'query'],
        ];
    }

    #[TestDox('A Valinor mapper maps the merged parameters onto an object')]
    public function testValinorMapsTheSource(): void
    {
        $request = new ServerRequest(queryParams: ['term' => 'php', 'page' => '2'], parsedBody: ['term' => 'ignored'])
            ->withAttribute('tenant', 'acme');

        $searchQuery = new MapperBuilder()
            ->allowScalarValueCasting()
            ->mapper()
            ->map(SearchQuery::class, Source::iterable(new ServerRequestSource($request)));

        Assert::assertEquals(new SearchQuery(term: 'php', page: 2, tenant: 'acme'), $searchQuery);
    }
}
