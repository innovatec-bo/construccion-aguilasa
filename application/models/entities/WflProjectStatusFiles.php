<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflProjectStatusFiles
 *
 * @ORM\Table(name="wfl_project_status_files")
 * @ORM\Entity
 */
class WflProjectStatusFiles
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_psf", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPsf;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status_log_id_psf", type="bigint", nullable=true)
     */
    private $statusLogIdPsf;

    /**
     * @var int|null
     *
     * @ORM\Column(name="project_id_psf", type="bigint", nullable=true)
     */
    private $projectIdPsf;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status_id_psf", type="bigint", nullable=true)
     */
    private $statusIdPsf;

    /**
     * @var int|null
     *
     * @ORM\Column(name="file_id_psf", type="bigint", nullable=true)
     */
    private $fileIdPsf;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_psf", type="smallint", nullable=true)
     */
    private $deletedPsf = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_psf", type="datetime", nullable=true)
     */
    private $createdonPsf;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_psf", type="bigint", nullable=true)
     */
    private $createdbyPsf;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_psf", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonPsf = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_psf", type="bigint", nullable=true)
     */
    private $editedbyPsf;


}
