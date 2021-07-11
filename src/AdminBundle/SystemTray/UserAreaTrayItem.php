<?php

namespace Rabble\AdminBundle\SystemTray;

use Rabble\AdminBundle\SystemTray\UserArea\UserAreaItemInterface;

class UserAreaTrayItem extends AbstractSystemTrayItem
{
    /** @var UserAreaItemInterface[] */
    private array $userAreaItems = [];

    public function addUserAreaItem(UserAreaItemInterface $userAreaItem): void
    {
        $this->userAreaItems[] = $userAreaItem;
    }

    /**
     * @return UserAreaItemInterface[]
     */
    public function getItems(): array
    {
        return $this->userAreaItems;
    }

    /**
     * @param UserAreaItemInterface[] $userAreaItems
     */
    public function setItems(array $userAreaItems): void
    {
        $this->userAreaItems = $userAreaItems;
    }

    public function render(): string
    {
        $content = '';
        foreach ($this->userAreaItems as $userAreaItem) {
            $content .= $userAreaItem->render($this->twig);
        }

        return $this->twig->render('@RabbleAdmin/SystemTray/UserArea.html.twig', [
            'content' => $content,
        ]);
    }
}
