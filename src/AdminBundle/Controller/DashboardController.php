<?php

namespace Rabble\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    public function indexAction()
    {
        return $this->render('@RabbleAdmin/Dashboard/index.html.twig');
    }
}
