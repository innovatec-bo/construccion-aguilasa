<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MatInternals
 *
 * @ORM\Table(name="wfl_production_limits", indexes={@ORM\Index(name="fk_project_id_prl", columns={"project_id_prl"})})
 * @ORM\Entity
 */
class ProductionLimit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_prl", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPrl;

    /**
     * Many production limits has one project
     * @ORM\ManyToOne(targetEntity="WflProjects")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id_prl", referencedColumnName="id_pro")
     * })
     */
    private $projectId;

    /**
     * @var float|null
     *
     * @ORM\Column(name="limit_prl", type="decimal", precision=8, scale=2, nullable=true, options={"default"="110.00"})
     */
    private $limit;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="start_date_prl", type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="end_date_prl", type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_prl", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedPrl;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_prl", type="datetime", nullable=true)
     */
    private $createdonPrl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_prl", type="bigint", nullable=true)
     */
    private $createdbyPrl;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="editedon_prl", type="datetime", nullable=true, options={"default"=null})
     */
    private $editedonMat = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_prl", type="bigint", nullable=true)
     */
    private $editedbyPrl;


}
