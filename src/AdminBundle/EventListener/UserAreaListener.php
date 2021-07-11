<?php

namespace Rabble\AdminBundle\EventListener;

use Rabble\AdminBundle\SystemTray\UserArea\LinkItem;
use Rabble\AdminBundle\SystemTray\UserArea\SeparatorItem;
use Rabble\AdminBundle\SystemTray\UserAreaTrayItem;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserAreaListener
{
    private UserAreaTrayItem $userAreaTrayItem;

    private TranslatorInterface $translator;

    public function __construct(UserAreaTrayItem $userAreaTrayItem, TranslatorInterface $translator)
    {
        $this->userAreaTrayItem = $userAreaTrayItem;
        $this->translator = $translator;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if ($event->isMainRequest()) {
            $items = $this->userAreaTrayItem->getItems();
            $lastItem = end($items);
            if ($lastItem instanceof LinkItem) {
                $this->userAreaTrayItem->addUserAreaItem(new SeparatorItem());
            }
            $this->userAreaTrayItem->addUserAreaItem(new LinkItem(
                $this->translator->trans('user_area.logout', [], 'RabbleAdminBundle'),
                'rabble_admin_auth_logout',
                [],
                'ti-power-off'
            ));
        }
    }
}
