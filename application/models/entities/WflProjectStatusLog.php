<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflProjectStatusLog
 *
 * @ORM\Table(name="wfl_project_status_log", indexes={@ORM\Index(name="fk_project_id_psl", columns={"project_id_psl"}), @ORM\Index(name="fk_status_id_psl", columns={"status_id_psl"})})
 * @ORM\Entity
 */
class WflProjectStatusLog
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_psl", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPsl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="log_detail_psl", type="text", length=65535, nullable=true)
     */
    private $logDetailPsl;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="manual_entry_date_psl", type="datetime", nullable=true)
     */
    private $manualEntryDatePsl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_psl", type="smallint", nullable=true)
     */
    private $deletedPsl = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_psl", type="datetime", nullable=true)
     */
    private $createdonPsl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_psl", type="bigint", nullable=true)
     */
    private $createdbyPsl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_psl", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonPsl = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_psl", type="bigint", nullable=true)
     */
    private $editedbyPsl;

    /**
     * @var \WflProjects
     *
     * @ORM\ManyToOne(targetEntity="WflProjects")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id_psl", referencedColumnName="id_pro")
     * })
     */
    private $projectIdPsl;

    /**
     * @var \WflProjectStatus
     *
     * @ORM\ManyToOne(targetEntity="WflProjectStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id_psl", referencedColumnName="id_pst")
     * })
     */
    private $statusIdPsl;


}
