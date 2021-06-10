<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflProjectPoints
 *
 * @ORM\Table(name="wfl_project_points", indexes={@ORM\Index(name="fk_status_log_id_prp", columns={"status_log_id_prp"})})
 * @ORM\Entity
 */
class WflProjectPoints
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_prp", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPrp;

    /**
     * @var int|null
     *
     * @ORM\Column(name="points_quantity_prp", type="smallint", nullable=true)
     */
    private $pointsQuantityPrp;

    /**
     * @var float|null
     *
     * @ORM\Column(name="distance_prp", type="float", precision=5, scale=2, nullable=true)
     */
    private $distancePrp;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_prp", type="smallint", nullable=true)
     */
    private $deletedPrp = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_prp", type="datetime", nullable=true)
     */
    private $createdonPrp;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_prp", type="bigint", nullable=true)
     */
    private $createdbyPrp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_prp", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonPrp = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_prp", type="bigint", nullable=true)
     */
    private $editedbyPrp;

    /**
     * @var \WflProjectStatusLog
     *
     * @ORM\ManyToOne(targetEntity="WflProjectStatusLog")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_log_id_prp", referencedColumnName="id_psl")
     * })
     */
    private $statusLogIdPrp;


}
