<?php

declare(strict_types=1);

namespace DelOlmo\Valinor\Mapper\Source\Tests\Fixtures;

final readonly class SearchQuery
{
    public function __construct(
        public string $term,
        public int $page,
        public string $tenant,
    ) {
    }
}
