<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BuiLaborCost
 *
 * @ORM\Table(name="bui_labor_cost")
 * @ORM\Entity
 */
class BuiLaborCost
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_lac", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLac;

    /**
     * @var int|null
     *
     * @ORM\Column(name="labor_detail_id_lac", type="bigint", nullable=true)
     */
    private $laborDetailIdLac;

    /**
     * @var int|null
     *
     * @ORM\Column(name="building_structure_id_lac", type="bigint", nullable=true)
     */
    private $buildingStructureIdLac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="activity_lac", type="string", length=5, nullable=true)
     */
    private $activityLac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="execution_lac", type="string", length=5, nullable=true)
     */
    private $executionLac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="quantity_lac", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $quantityLac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="unit_price_lac", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $unitPriceLac;

    /**
     * @var int|null
     *
     * @ORM\Column(name="is_additional_lac", type="smallint", nullable=true)
     */
    private $isAdditionalLac = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_lac", type="smallint", nullable=true)
     */
    private $deletedLac = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_lac", type="datetime", nullable=true)
     */
    private $createdonLac;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_lac", type="bigint", nullable=true)
     */
    private $createdbyLac;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_lac", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonLac = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_lac", type="bigint", nullable=true)
     */
    private $editedbyLac;


}
