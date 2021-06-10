<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BuiBuildingStructures
 *
 * @ORM\Table(name="bui_building_structures")
 * @ORM\Entity
 */
class BuiBuildingStructures
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_bus", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idBus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="structure_code_bus", type="string", length=30, nullable=true)
     */
    private $structureCodeBus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description_bus", type="text", length=65535, nullable=true)
     */
    private $descriptionBus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="unit_of_measurement_bus", type="string", length=20, nullable=true)
     */
    private $unitOfMeasurementBus;

    /**
     * @var int|null
     *
     * @ORM\Column(name="budget_type_bus", type="smallint", nullable=true)
     */
    private $budgetTypeBus;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_bus", type="smallint", nullable=true)
     */
    private $deletedBus = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_bus", type="datetime", nullable=true)
     */
    private $createdonBus;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_bus", type="bigint", nullable=true)
     */
    private $createdbyBus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_bus", type="datetime", nullable=false, options={"default"="2018-01-01 00:00:00"})
     */
    private $editedonBus = '2018-01-01 00:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_bus", type="bigint", nullable=true)
     */
    private $editedbyBus;


}
