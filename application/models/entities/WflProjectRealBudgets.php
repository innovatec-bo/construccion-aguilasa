<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflProjectRealBudgets
 *
 * @ORM\Table(name="wfl_project_real_budgets", indexes={@ORM\Index(name="fk_status_log_id_reb", columns={"status_log_id_reb"})})
 * @ORM\Entity
 */
class WflProjectRealBudgets
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_reb", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReb;

    /**
     * @var float|null
     *
     * @ORM\Column(name="design_reb", type="float", precision=10, scale=2, nullable=true)
     */
    private $designReb;

    /**
     * @var float|null
     *
     * @ORM\Column(name="building_reb", type="float", precision=10, scale=2, nullable=true)
     */
    private $buildingReb;

    /**
     * @var float|null
     *
     * @ORM\Column(name="transportation_reb", type="float", precision=10, scale=2, nullable=true)
     */
    private $transportationReb;

    /**
     * @var float|null
     *
     * @ORM\Column(name="live_line_reb", type="float", precision=10, scale=2, nullable=true)
     */
    private $liveLineReb;

    /**
     * @var float|null
     *
     * @ORM\Column(name="right_of_way_reb", type="float", precision=10, scale=2, nullable=true)
     */
    private $rightOfWayReb;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_reb", type="smallint", nullable=true)
     */
    private $deletedReb = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_reb", type="datetime", nullable=true)
     */
    private $createdonReb;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_reb", type="bigint", nullable=true)
     */
    private $createdbyReb;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_reb", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonReb = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_reb", type="bigint", nullable=true)
     */
    private $editedbyReb;

    /**
     * @var \WflProjectStatusLog
     *
     * @ORM\ManyToOne(targetEntity="WflProjectStatusLog")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_log_id_reb", referencedColumnName="id_psl")
     * })
     */
    private $statusLogIdReb;


}
