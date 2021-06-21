<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BuiWorkedUpStructures
 *
 * @ORM\Table(name="bui_worked_up_structures")
 * @ORM\Entity
 */
class BuiWorkedUpStructures
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_wus", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idWus;

    /**
     * @var int|null
     *
     * @ORM\Column(name="labor_cost_log_id_wus", type="bigint", nullable=true)
     */
    private $laborCostLogIdWus;

    /**
     * @var int|null
     *
     * @ORM\Column(name="labor_cost_id_wus", type="bigint", nullable=true)
     */
    private $laborCostIdWus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="worked_up_wus", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $workedUpWus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="price_wus", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $priceWus;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_wus", type="smallint", nullable=true)
     */
    private $deletedWus;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_wus", type="datetime", nullable=true)
     */
    private $createdonWus;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_wus", type="bigint", nullable=true)
     */
    private $createdbyWus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_wus", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonWus = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_wus", type="bigint", nullable=true)
     */
    private $editedbyWus;


}
