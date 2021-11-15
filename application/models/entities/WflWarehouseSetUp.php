<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflWarehouseSetUp
 *
 * @ORM\Table(name="wfl_warehouse_setup", uniqueConstraints={@ORM\UniqueConstraint(name="UQ_wfl_warehouse_id_wsu", columns={"id_wsu"})})
 * @ORM\Entity
 */
class WflWarehouseSetUp
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_wsu", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_wsu", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedRol;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_wsu", type="datetime", nullable=true)
     */
    private $createdonRol;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_wsu", type="bigint", nullable=true)
     */
    private $createdbyRol;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_wsu", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonRol = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_wsu", type="bigint", nullable=true)
     */
    private $editedbyRol;
}
