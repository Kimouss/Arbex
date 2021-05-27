<?php

namespace App\EventSubscriber;

use App\Manager\KnpMenuManager;
use KevinPapst\AdminLTEBundle\Event\KnpMenuEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class KnpMenuBuilderSubscriber implements EventSubscriberInterface
{
    /**
     * @var KnpMenuManager
     */
    private $knpMenuManager;

    public function __construct(KnpMenuManager $knpMenuManager)
    {
        $this->knpMenuManager = $knpMenuManager;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KnpMenuEvent::class => ['onSetupMenu', 100],
        ];
    }

    public function onSetupMenu(KnpMenuEvent $event)
    {
        $this->knpMenuManager->knpMenuBuilder($event);
    }
}
