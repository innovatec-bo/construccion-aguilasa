<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * SysFiles
 *
 * @ORM\Table(name="sys_files", uniqueConstraints={@ORM\UniqueConstraint(name="UQ_sys_files_id_fil", columns={"id_fil"})})
 * @ORM\Entity
 */
class SysFiles
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_fil", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFil;

    /**
     * @var string|null
     *
     * @ORM\Column(name="uploadfilename_fil", type="string", length=60, nullable=true)
     */
    private $uploadfilenameFil;

    /**
     * @var string|null
     *
     * @ORM\Column(name="filename_fil", type="string", length=50, nullable=true)
     */
    private $filenameFil;

    /**
     * @var string|null
     *
     * @ORM\Column(name="filepath_fil", type="string", length=50, nullable=true)
     */
    private $filepathFil;

    /**
     * @var string|null
     *
     * @ORM\Column(name="extension_fil", type="string", length=6, nullable=true)
     */
    private $extensionFil;

    /**
     * @var int|null
     *
     * @ORM\Column(name="size_fil", type="integer", nullable=true)
     */
    private $sizeFil;

    /**
     * @var int|null
     *
     * @ORM\Column(name="height_fil", type="integer", nullable=true)
     */
    private $heightFil;

    /**
     * @var int|null
     *
     * @ORM\Column(name="width_fil", type="integer", nullable=true)
     */
    private $widthFil;

    /**
     * @var int|null
     *
     * @ORM\Column(name="mimetype_fil", type="integer", nullable=true)
     */
    private $mimetypeFil;

    /**
     * @var string|null
     *
     * @ORM\Column(name="hash_fil", type="text", length=65535, nullable=true)
     */
    private $hashFil;

    /**
     * @var string|null
     *
     * @ORM\Column(name="url_fil", type="text", length=65535, nullable=true)
     */
    private $urlFil;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_fil", type="smallint", nullable=true)
     */
    private $deletedFil = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_fil", type="datetime", nullable=true)
     */
    private $createdonFil;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_fil", type="bigint", nullable=true)
     */
    private $createdbyFil;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_fil", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonFil = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_fil", type="bigint", nullable=true)
     */
    private $editedbyFil;


}
