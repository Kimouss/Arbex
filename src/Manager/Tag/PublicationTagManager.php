<?php


namespace App\Manager\Tag;


use App\Entity\Tag\PublicationTag;
use App\Entity\Tag\UserTag;
use Doctrine\ORM\EntityManagerInterface;

class PublicationTagManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createFromUserTag(UserTag $userTag)
    {
        $publicationTag = new PublicationTag();
        $publicationTag->setTitle($userTag->getTitle());
        $this->entityManager->persist($publicationTag);
        $this->entityManager->flush();

        return $publicationTag;
    }

    public function editFromUserTag(string $oldTitle, UserTag $userTagNew)
    {
        $publicationTag = $this->entityManager->getRepository(PublicationTag::class)->findOneBy(['title' => $oldTitle]);
        if (!$publicationTag instanceof PublicationTag) {
            return $publicationTag;
        }

        $publicationTag->setTitle($userTagNew->getTitle());
        $this->entityManager->persist($publicationTag);
        $this->entityManager->flush();

        return $publicationTag;
    }

    public function removeFromUserTag(UserTag $userTag)
    {
        $publicationTag = $this->entityManager->getRepository(PublicationTag::class)->findOneBy(['title' => $userTag->getTitle()]);
        if (!$publicationTag instanceof PublicationTag) {
            return $publicationTag;
        }

        $this->entityManager->remove($publicationTag);
        $this->entityManager->flush();

        return true;
    }
}
