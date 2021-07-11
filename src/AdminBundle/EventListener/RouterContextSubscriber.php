<?php

namespace Rabble\AdminBundle\EventListener;

use Rabble\UserBundle\Entity\User;
use Rabble\UserBundle\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RequestContextAwareInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RouterContextSubscriber implements EventSubscriberInterface
{
    public const CONTENT_LOCALE_KEY = '_content_locale';

    private string $defaultLocale;
    private RequestContextAwareInterface $contextAware;
    private TokenStorageInterface $tokenStorage;
    private UserRepository $userRepository;

    public function __construct(
        string $defaultLocale,
        RequestContextAwareInterface $contextAware,
        TokenStorageInterface $tokenStorage,
        UserRepository $userRepository
    ) {
        $this->defaultLocale = $defaultLocale;
        $this->contextAware = $contextAware;
        $this->tokenStorage = $tokenStorage;
        $this->userRepository = $userRepository;
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::REQUEST => 'onKernelRequest'];
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $defaultLocale = $this->defaultLocale;
        $token = $this->tokenStorage->getToken();
        $user = null;
        if (null !== $token && null !== ($user = $token->getUser()) && $user instanceof User) {
            $defaultLocale = $user->getSetting('content_locale', $defaultLocale);
        }
        $locale = $event->getRequest()->attributes->get(self::CONTENT_LOCALE_KEY, $defaultLocale);
        $this->contextAware->getContext()->setParameter(self::CONTENT_LOCALE_KEY, $locale);
        if ($defaultLocale !== $locale && $user instanceof User) {
            $user->addSetting('content_locale', $locale);
            $this->userRepository->save($user);
        }
    }
}
