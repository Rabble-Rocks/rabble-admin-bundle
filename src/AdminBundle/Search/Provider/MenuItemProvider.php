<?php

namespace Rabble\AdminBundle\Search\Provider;

use Knp\Menu\ItemInterface;
use Rabble\AdminBundle\Menu\AdminMenuBuilder;
use Rabble\AdminBundle\Search\SearchProviderInterface;
use Rabble\AdminBundle\Search\SearchResult;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;

class MenuItemProvider implements SearchProviderInterface
{
    private RequestStack $requestStack;

    private AdminMenuBuilder $menuBuilder;

    private TranslatorInterface $translator;

    public function __construct(
        RequestStack $requestStack,
        AdminMenuBuilder $menuBuilder,
        TranslatorInterface $translator
    ) {
        $this->requestStack = $requestStack;
        $this->menuBuilder = $menuBuilder;
        $this->translator = $translator;
    }

    public function search($query): array
    {
        $menu = $this->menuBuilder->buildSideMenu($this->requestStack);

        return $this->extractMatches($query, $menu);
    }

    /**
     * Executes the search query by iterating over all menu items recursively.
     *
     * @param $query
     *
     * @return SearchResult[]
     */
    private function extractMatches($query, ItemInterface $menuItem)
    {
        $matches = [];
        foreach ($menuItem->getChildren() as $childItem) {
            if ($childItem->hasChildren()) {
                foreach ($this->extractMatches($query, $childItem) as $match) {
                    $matches[] = $match;
                }
            } else {
                $label = $childItem->getLabel();
                $translationDomain = $childItem->getExtra('translation_domain', 'messages');
                if (false !== $translationDomain) {
                    $label = $this->translator->trans($label, $childItem->getExtra('translation_params', []), $translationDomain);
                }
                if (false !== stripos($label, $query)) {
                    similar_text(strtolower($label), strtolower($query), $score);
                    $matches[] = new SearchResult(
                        $label,
                        $this->translator->trans('search.type.menu_item', [], 'RabbleAdminBundle'),
                        $childItem->getUri(),
                        ($score / 100) - 0.15 // Menu items should be treated as less important than potential other things.
                    );
                }
            }
        }

        return $matches;
    }
}
