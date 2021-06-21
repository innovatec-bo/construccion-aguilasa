<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflProjectBudgets
 *
 * @ORM\Table(name="wfl_project_budgets", indexes={@ORM\Index(name="fk_status_log_id_prb", columns={"status_log_id_prb"})})
 * @ORM\Entity
 */
class WflProjectBudgets
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_prb", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPrb;

    /**
     * @var float|null
     *
     * @ORM\Column(name="design_prb", type="float", precision=10, scale=0, nullable=true)
     */
    private $designPrb;

    /**
     * @var float|null
     *
     * @ORM\Column(name="building_prb", type="float", precision=10, scale=0, nullable=true)
     */
    private $buildingPrb;

    /**
     * @var string|null
     *
     * @ORM\Column(name="graph_number_prb", type="string", length=20, nullable=true)
     */
    private $graphNumberPrb;

    /**
     * @var string|null
     *
     * @ORM\Column(name="reservation_number_prb", type="string", length=20, nullable=true)
     */
    private $reservationNumberPrb;

    /**
     * @var float|null
     *
     * @ORM\Column(name="transportation_prb", type="float", precision=10, scale=0, nullable=true)
     */
    private $transportationPrb;

    /**
     * @var float|null
     *
     * @ORM\Column(name="live_line_prb", type="float", precision=10, scale=0, nullable=true)
     */
    private $liveLinePrb;

    /**
     * @var float|null
     *
     * @ORM\Column(name="right_of_way_prb", type="float", precision=10, scale=0, nullable=true)
     */
    private $rightOfWayPrb;

    /**
     * @var float|null
     *
     * @ORM\Column(name="tentative_total_budget_prb", type="float", precision=10, scale=0, nullable=true)
     */
    private $tentativeTotalBudgetPrb;

    /**
     * @var int|null
     *
     * @ORM\Column(name="manpower_file_id_prb", type="bigint", nullable=true)
     */
    private $manpowerFileIdPrb;

    /**
     * @var int|null
     *
     * @ORM\Column(name="building_structure_file_id_prb", type="bigint", nullable=true)
     */
    private $buildingStructureFileIdPrb;

    /**
     * @var int|null
     *
     * @ORM\Column(name="materials_file_id_prb", type="bigint", nullable=true)
     */
    private $materialsFileIdPrb;

    /**
     * @var int|null
     *
     * @ORM\Column(name="trim_tree_prb", type="smallint", nullable=true)
     */
    private $trimTreePrb;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_prb", type="smallint", nullable=true)
     */
    private $deletedPrb;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_prb", type="datetime", nullable=true)
     */
    private $createdonPrb;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_prb", type="bigint", nullable=true)
     */
    private $createdbyPrb;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_prb", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonPrb = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_prb", type="bigint", nullable=true)
     */
    private $editedbyPrb;

    /**
     * @var \WflProjectStatusLog
     *
     * @ORM\ManyToOne(targetEntity="WflProjectStatusLog")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_log_id_prb", referencedColumnName="id_psl")
     * })
     */
    private $statusLogIdPrb;


}
