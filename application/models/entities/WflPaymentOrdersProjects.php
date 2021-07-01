<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflPaymentOrdersProjects
 *
 * @ORM\Table(name="wfl_payment_orders_projects", indexes={@ORM\Index(name="fk_order_id_pop", columns={"order_id_pop"}), @ORM\Index(name="fk_project_id_pop", columns={"project_id_pop"})})
 * @ORM\Entity
 */
class WflPaymentOrdersProjects
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_pop", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPop;

    /**
     * @var float|null
     *
     * @ORM\Column(name="design_budget_pop", type="float", precision=10, scale=0, nullable=true)
     */
    private $designBudgetPop;

    /**
     * @var float|null
     *
     * @ORM\Column(name="transportation_budget_pop", type="float", precision=10, scale=0, nullable=true)
     */
    private $transportationBudgetPop;

    /**
     * @var float|null
     *
     * @ORM\Column(name="building_budget_pop", type="float", precision=10, scale=0, nullable=true)
     */
    private $buildingBudgetPop;

    /**
     * @var float|null
     *
     * @ORM\Column(name="live_line_budget_pop", type="float", precision=10, scale=0, nullable=true)
     */
    private $liveLineBudgetPop;

    /**
     * @var float|null
     *
     * @ORM\Column(name="right_of_way_budget_pop", type="float", precision=10, scale=0, nullable=true)
     */
    private $rightOfWayBudgetPop;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_pop", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedPop;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_pop", type="datetime", nullable=true)
     */
    private $createdonPop;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_pop", type="bigint", nullable=true)
     */
    private $createdbyPop;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_pop", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonPop = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_pop", type="bigint", nullable=true)
     */
    private $editedbyPop;

    /**
     * @var \WflPaymentOrders
     *
     * @ORM\ManyToOne(targetEntity="WflPaymentOrders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id_pop", referencedColumnName="id_pao")
     * })
     */
    private $orderIdPop;

    /**
     * @var \WflProjects
     *
     * @ORM\ManyToOne(targetEntity="WflProjects")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id_pop", referencedColumnName="id_pro")
     * })
     */
    private $projectIdPop;


}
