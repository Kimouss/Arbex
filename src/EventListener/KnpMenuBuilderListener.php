<?php

namespace App\EventListener;

use App\Manager\KnpMenuManager;
use KevinPapst\AdminLTEBundle\Event\KnpMenuEvent;

class KnpMenuBuilderListener
{
    /**
     * @var KnpMenuManager
     */
    private $knpMenuManager;

    public function __construct(KnpMenuManager $knpMenuManager)
    {
        $this->knpMenuManager = $knpMenuManager;
    }

    public function onSetupMenu(KnpMenuEvent $event)
    {
        $this->knpMenuManager->knpMenuBuilder($event);
    }
}
