<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflWorkPlanDates
 *
 * @ORM\Table(name="wfl_work_plan_dates", indexes={@ORM\Index(name="fk_work_plan_id_wpd", columns={"work_plan_id_wpd"}), @ORM\Index(name="fk_project_id_wpd", columns={"project_id_wpd"})})
 * @ORM\Entity
 */
class WflWorkPlanDates
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_wpd", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idWpd;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_wpd", type="date", nullable=true)
     */
    private $dateWpd;

    /**
     * @var string|null
     *
     * @ORM\Column(name="detail_wpd", type="text", length=65535, nullable=true)
     */
    private $detailWpd;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observation_wpd", type="text", length=65535, nullable=true)
     */
    private $observationWpd;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_wpd", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedWpd;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_wpd", type="datetime", nullable=true)
     */
    private $createdonWpd;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_wpd", type="bigint", nullable=true)
     */
    private $createdbyWpd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_wpd", type="datetime", nullable=true, options={"default"=null})
     */
    private $editedonWpd;

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_wpd", type="bigint", nullable=true)
     */
    private $editedbyWpd;

    /**
     * @var \WflProjects
     *
     * @ORM\ManyToOne(targetEntity="WflProjects")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id_wpd", referencedColumnName="id_pro")
     * })
     */
    private $projectIdWpd;

    /**
     * @var \WflWorkPlans
     *
     * @ORM\ManyToOne(targetEntity="WflWorkPlans")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="work_plan_id_wpd", referencedColumnName="id_wpl")
     * })
     */
    private $workPlanIdWpd;


}
