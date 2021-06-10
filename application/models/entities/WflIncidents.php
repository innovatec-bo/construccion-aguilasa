<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflIncidents
 *
 * @ORM\Table(name="wfl_incidents", indexes={@ORM\Index(name="fk_status_id_inc", columns={"status_id_inc"}), @ORM\Index(name="fk_project_id_inc", columns={"project_id_inc"})})
 * @ORM\Entity
 */
class WflIncidents
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_inc", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idInc;

    /**
     * @var int|null
     *
     * @ORM\Column(name="percentage_inc", type="smallint", nullable=true)
     */
    private $percentageInc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="detail_inc", type="text", length=65535, nullable=true)
     */
    private $detailInc;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="manual_entry_date_inc", type="datetime", nullable=true)
     */
    private $manualEntryDateInc;

    /**
     * @var int|null
     *
     * @ORM\Column(name="paused_inc", type="smallint", nullable=true)
     */
    private $pausedInc = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="stopped_inc", type="smallint", nullable=true)
     */
    private $stoppedInc;

    /**
     * @var int|null
     *
     * @ORM\Column(name="incident_type_inc", type="integer", nullable=true)
     */
    private $incidentTypeInc;

    /**
     * @var int|null
     *
     * @ORM\Column(name="need_to_be_solved_inc", type="smallint", nullable=true)
     */
    private $needToBeSolvedInc = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="solved_on_date_inc", type="datetime", nullable=true)
     */
    private $solvedOnDateInc;

    /**
     * @var int|null
     *
     * @ORM\Column(name="solved_by_inc", type="bigint", nullable=true)
     */
    private $solvedByInc;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_inc", type="smallint", nullable=true)
     */
    private $deletedInc = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_inc", type="datetime", nullable=true)
     */
    private $createdonInc;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_inc", type="bigint", nullable=true)
     */
    private $createdbyInc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_inc", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonInc = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_inc", type="bigint", nullable=true)
     */
    private $editedbyInc;

    /**
     * @var \WflProjects
     *
     * @ORM\ManyToOne(targetEntity="WflProjects")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id_inc", referencedColumnName="id_pro")
     * })
     */
    private $projectIdInc;

    /**
     * @var \WflProjectStatus
     *
     * @ORM\ManyToOne(targetEntity="WflProjectStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id_inc", referencedColumnName="id_pst")
     * })
     */
    private $statusIdInc;


}
