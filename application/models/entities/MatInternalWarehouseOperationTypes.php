<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MatInternalWarehouseOperationTypes
 *
 * @ORM\Table(name="mat_internal_warehouse_operation_types")
 * @ORM\Entity
 */
class MatInternalWarehouseOperationTypes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_oty", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name_oty", type="text", length=65535, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="keyword_oty", type="string", length=50, nullable=true)
     */
    private $keyword;

    /**
     * @var string|null
     *
     * @ORM\Column(name="icon_oty", type="string", length=60, nullable=true)
     */
    private $icon;

    /**
     * @var string|null
     *
     * @ORM\Column(name="operation_type_oty", type="string", length=30, nullable=true)
     */
    private $operationType;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_oty", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deleted;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_oty", type="datetime", nullable=true)
     */
    private $createdon;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_oty", type="bigint", nullable=true)
     */
    private $createdby;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_oty", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonMqt = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_oty", type="bigint", nullable=true)
     */
    private $editedby;


}
