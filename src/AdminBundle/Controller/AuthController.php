<?php

namespace Rabble\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security\FirewallConfig;
use Symfony\Bundle\SecurityBundle\Security\FirewallMap;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    private FirewallMap $firewallMap;

    public function __construct(FirewallMap $firewallMap)
    {
        $this->firewallMap = $firewallMap;
    }

    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        if ($this->getUser() instanceof UserInterface && in_array('ROLE_RABBLE_ADMIN', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('rabble_admin_dashboard');
        }
        $firewall = $this->firewallMap->getFirewallConfig($request);
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@RabbleAdmin/Auth/login.html.twig', [
            'error' => $error,
            'lastUsername' => $lastUsername,
            'rememberMe' => $firewall instanceof FirewallConfig && in_array('remember_me', $firewall->getAuthenticators(), true),
        ]);
    }
}
