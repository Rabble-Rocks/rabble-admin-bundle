<?php

namespace Rabble\AdminBundle\Search;

class SearchManager implements SearchProviderInterface
{
    /**
     * @var SearchProviderInterface[]
     */
    private array $providers = [];

    public function addProvider(SearchProviderInterface $searchProvider)
    {
        $this->providers[] = $searchProvider;
    }

    /**
     * @param $query
     *
     * @return SearchResult[]
     */
    public function search($query): array
    {
        $results = [];
        foreach ($this->providers as $searchProvider) {
            foreach ($searchProvider->search($query) as $result) {
                if ($result->getScore() > 0) {
                    $results[] = $result;
                }
            }
        }
        usort($results, function (SearchResult $a, SearchResult $b) {
            if ($a->getScore() === $b->getScore()) {
                return 0;
            }

            return $a->getScore() < $b->getScore() ? 1 : -1;
        });

        return $results;
    }
}
