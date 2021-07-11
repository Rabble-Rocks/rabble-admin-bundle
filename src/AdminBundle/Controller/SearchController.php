<?php

namespace Rabble\AdminBundle\Controller;

use Rabble\AdminBundle\Search\SearchManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
    private $searchManager;

    public function __construct(SearchManager $searchManager)
    {
        $this->searchManager = $searchManager;
    }

    public function searchAction(Request $request)
    {
        $query = trim($request->query->get('q'));
        if ('' === $query) {
            return $this->redirectToRoute('rabble_admin_dashboard');
        }
        $results = $this->searchManager->search($query);

        return $this->render('@RabbleAdmin/Search/search.html.twig', [
            'results' => $results,
        ]);
    }
}
