<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MatInternals
 *
 * @ORM\Table(name="mat_internals")
 * @ORM\Entity
 */
class MatInternals
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_int", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idInt;

    /**
     * @var int|null
     *
     * @ORM\Column(name="material_id_int", type="bigint", nullable=true)
     */
    private $materialIdInt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="quantity_int", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $quantityInt;
    
    /**
     * @var int|null
     *
     * @ORM\Column(name="status_id_int", type="bigint", nullable=true)
     */
    private $statusIdInt;

    /**
     * @var int|null
     *
     * @ORM\Column(name="tension_id_int", type="smallint", nullable=true)
     */
    
    private $tensionIdInt;
    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_int", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedInt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_int", type="datetime", nullable=true)
     */
    private $createdonInt;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_int", type="bigint", nullable=true)
     */
    private $createdbyInt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="editedon_int", type="datetime", nullable=true, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonMat = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_int", type="bigint", nullable=true)
     */
    private $editedbyInt;


}
