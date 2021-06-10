<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BuiStructureByPoints
 *
 * @ORM\Table(name="bui_structure_by_points")
 * @ORM\Entity
 */
class BuiStructureByPoints
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_sbp", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSbp;

    /**
     * @var int|null
     *
     * @ORM\Column(name="project_id_sbp", type="bigint", nullable=true)
     */
    private $projectIdSbp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="label_sbp", type="string", length=30, nullable=true)
     */
    private $labelSbp;

    /**
     * @var int|null
     *
     * @ORM\Column(name="point_id_sbp", type="bigint", nullable=true)
     */
    private $pointIdSbp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="quantity_to_use_sbp", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $quantityToUseSbp;

    /**
     * @var int|null
     *
     * @ORM\Column(name="labor_cost_id_sbp", type="bigint", nullable=true)
     */
    private $laborCostIdSbp;

    /**
     * @var int|null
     *
     * @ORM\Column(name="is_additional_sbp", type="smallint", nullable=true)
     */
    private $isAdditionalSbp = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_sbp", type="smallint", nullable=true)
     */
    private $deletedSbp = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_sbp", type="datetime", nullable=true)
     */
    private $createdonSbp;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_sbp", type="bigint", nullable=true)
     */
    private $createdbySbp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_sbp", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonSbp = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_sbp", type="bigint", nullable=true)
     */
    private $editedbySbp;


}
