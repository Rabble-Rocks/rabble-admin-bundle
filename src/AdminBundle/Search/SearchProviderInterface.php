<?php

namespace Rabble\AdminBundle\Search;

interface SearchProviderInterface
{
    /**
     * @param $query
     *
     * @return SearchResult[]
     */
    public function search($query): array;
}
