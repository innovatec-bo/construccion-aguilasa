<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BuiDefaultStructureMaterials
 *
 * @ORM\Table(name="bui_default_structure_materials")
 * @ORM\Entity
 */
class BuiDefaultStructureMaterials
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_dsm", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDsm;

    /**
     * @var int|null
     *
     * @ORM\Column(name="structure_id_dsm", type="bigint", nullable=true)
     */
    private $structureIdDsm;

    /**
     * @var int|null
     *
     * @ORM\Column(name="material_id_dsm", type="bigint", nullable=true)
     */
    private $materialIdDsm;

    /**
     * @var string|null
     *
     * @ORM\Column(name="quantity_dsm", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $quantityDsm;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_dsm", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedDsm;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_dsm", type="datetime", nullable=true)
     */
    private $createdonDsm;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_dsm", type="bigint", nullable=true)
     */
    private $createdbyDsm;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_dsm", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonDsm = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_dsm", type="bigint", nullable=true)
     */
    private $editedbyDsm;


}
