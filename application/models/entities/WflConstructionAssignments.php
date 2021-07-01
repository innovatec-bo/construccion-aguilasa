<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflConstructionAssignments
 *
 * @ORM\Table(name="wfl_construction_assignments", indexes={@ORM\Index(name="fk_status_log_id_cas", columns={"status_log_id_cas"})})
 * @ORM\Entity
 */
class WflConstructionAssignments
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_cas", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCas;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="start_date_cas", type="datetime", nullable=true)
     */
    private $startDateCas;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="end_date_cas", type="datetime", nullable=true)
     */
    private $endDateCas;

    /**
     * @var int|null
     *
     * @ORM\Column(name="estimated_time_cas", type="smallint", nullable=true)
     */
    private $estimatedTimeCas;

    /**
     * @var int|null
     *
     * @ORM\Column(name="live_line_cas", type="smallint", nullable=true)
     */
    private $liveLineCas;

    /**
     * @var int|null
     *
     * @ORM\Column(name="power_down_cas", type="smallint", nullable=true)
     */
    private $powerDownCas;

    /**
     * @var int|null
     *
     * @ORM\Column(name="maneuver_cas", type="smallint", nullable=true)
     */
    private $maneuverCas;

    /**
     * @var int|null
     *
     * @ORM\Column(name="project_manager_cas", type="bigint", nullable=true)
     */
    private $projectManagerCas;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_cas", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedCas;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_cas", type="datetime", nullable=true)
     */
    private $createdonCas;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_cas", type="bigint", nullable=true)
     */
    private $createdbyCas;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_cas", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonCas = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_cas", type="bigint", nullable=true)
     */
    private $editedbyCas;

    /**
     * @var \WflProjectStatusLog
     *
     * @ORM\ManyToOne(targetEntity="WflProjectStatusLog")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_log_id_cas", referencedColumnName="id_psl")
     * })
     */
    private $statusLogIdCas;


}
