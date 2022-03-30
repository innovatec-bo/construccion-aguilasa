<?php
use Doctrine\ORM\Mapping as ORM;

/**
 * MaterialTension
 *
 * @ORM\Table(name="mat_material_tensions")
 * @ORM\Entity
 */
class MaterialTension
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_mte", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $_id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="detail_mte", type="string", length=100, nullable=true)
     */
    private $_detail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_mte", type="string", length=20, nullable=true)
     */
    private $_code;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_mte", type="smallint", nullable=true, options={"default"="0"})
     */
    private $_deleted;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_mte", type="datetime", nullable=true)
     */
    private $_createdOn;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_mte", type="bigint", nullable=true)
     */
    private $_createdBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_mte", type="datetime", nullable=true, options={"default"=null})
     */
    private $_editedOn = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_mte", type="bigint", nullable=true)
     */
    private $editedBy;
}
