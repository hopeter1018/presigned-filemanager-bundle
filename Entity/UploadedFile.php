<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Peter Ho <hokwaichi@gmail.com>
 *
 * @ORM\Table(name="presignedfilemanager_uploadedfile")
 * @ORM\Entity(repositoryClass="HoPeter1018\PresignedFilemanagerBundle\Repository\UploadedFileRepository")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 */
class UploadedFile
{
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
}
