<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BaseTable
 *
 * @ORM\Table(name="base_table")
 * @ORM\Entity
 */
class BaseTable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_", type="smallint", nullable=true, options={"default":0})
     */
    private $deleted = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_", type="datetime", nullable=true)
     */
    private $createdon;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_", type="bigint", nullable=true)
     */
    private $createdby;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedon = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_", type="bigint", nullable=true)
     */
    private $editedby;
}
