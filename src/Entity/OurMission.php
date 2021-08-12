<?php

namespace App\Entity;

use App\Repository\OurMissionRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=OurMissionRepository::class)
 * @Vich\Uploadable
 */
class OurMission
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
    private $missionImage;

    /**
     * @Vich\UploadableField(mapping="mission", fileNameProperty="missionImage")
     * @var File
     */
    private $missionImageFile;

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

    /**
     * @return string
     */
    public function getMissionImage(): ?string
    {
        return $this->missionImage;
    }

    /**
     * @param string $missionImage
     *
     * @return OurMission
     */
    public function setMissionImage(string $missionImage): OurMission
    {
        $this->missionImage = $missionImage;
        return $this;
    }

    /**
     * @return File
     */
    public function getMissionImageFile(): ?File
    {
        return $this->missionImageFile;
    }

    /**
     * @param File $missionImageFile
     *
     * @return OurMission
     */
    public function setMissionImageFile(File $missionImageFile): OurMission
    {
        $this->missionImageFile = $missionImageFile;
        if (null !== $missionImageFile) {
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }
}
