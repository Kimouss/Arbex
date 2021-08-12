<?php

namespace App\Entity;

use App\Repository\OurHistoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=OurHistoryRepository::class)
 * @Vich\Uploadable
 */
class OurHistory
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $text;


    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $historyImage;

    /**
     * @Vich\UploadableField(mapping="history", fileNameProperty="historyImage")
     * @var File
     */
    private $historyImageFile;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getHistoryImage(): ?string
    {
        return $this->historyImage;
    }

    public function setHistoryImage(string $historyImage): OurHistory
    {
        $this->historyImage = $historyImage;
        return $this;
    }

    public function getHistoryImageFile(): ?File
    {
        return $this->historyImageFile;
    }

    public function setHistoryImageFile(File $historyImageFile): OurHistory
    {
        $this->historyImageFile = $historyImageFile;
        if (null !== $historyImageFile) {
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }
}
