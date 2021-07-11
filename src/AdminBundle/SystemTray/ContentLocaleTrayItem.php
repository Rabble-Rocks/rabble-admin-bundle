<?php

namespace Rabble\AdminBundle\SystemTray;

use Rabble\AdminBundle\EventListener\RouterContextSubscriber;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

class ContentLocaleTrayItem extends AbstractSystemTrayItem
{
    private RequestStack $requestStack;
    /** @var string[] */
    private array $locales;

    /**
     * @param string[] $locales
     */
    public function __construct(Environment $twig, RequestStack $requestStack, array $locales)
    {
        parent::__construct($twig);
        $this->requestStack = $requestStack;
        $this->locales = $locales;
    }

    public function render(): string
    {
        $request = $this->requestStack->getMainRequest();
        if (null === $request || !$request->attributes->has(RouterContextSubscriber::CONTENT_LOCALE_KEY)) {
            return '';
        }

        return $this->twig->render('@RabbleAdmin/SystemTray/ContentLocale.html.twig', [
            'locales' => $this->locales,
        ]);
    }

    public function getWeight(): int
    {
        return -1;
    }
}
