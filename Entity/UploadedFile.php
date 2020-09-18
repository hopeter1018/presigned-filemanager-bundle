<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Peter Ho <hokwaichi@gmail.com>
 *
 * @ORM\Entity(repositoryClass="HoPeter1018\PresignedFilemanagerBundle\Repository\UploadedFileRepository")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 */
class UploadedFile
{
    /**
     * @var string
     *
     * @ORM\Column(name="entity_fqcn", type="string", length=255)
     * @Assert\NotNull
     */
    protected $entityFqcn;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * Get id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of Entity Fqcn.
     *
     * @return string
     */
    public function getEntityFqcn()
    {
        return $this->entityFqcn;
    }

    /**
     * Set the value of Entity Fqcn.
     *
     * @param string $entityFqcn
     *
     * @return self
     */
    public function setEntityFqcn($entityFqcn)
    {
        $this->entityFqcn = $entityFqcn;

        return $this;
    }
}
