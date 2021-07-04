<?php


namespace App\EventListener\Tag;

use App\Entity\Tag\UserTag;
use App\Manager\Tag\PublicationTagManager;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class UserTagListener
{
    private PublicationTagManager $publicationTagManager;

    public function __construct(PublicationTagManager $publicationTagManager)
    {
        $this->publicationTagManager = $publicationTagManager;
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $old = $args->getOldValue('title');
        $entity = $args->getEntity();
        if (!$entity instanceof UserTag) {
            return;
        }
        $this->publicationTagManager->editFromUserTag($old, $entity);
    }
}
