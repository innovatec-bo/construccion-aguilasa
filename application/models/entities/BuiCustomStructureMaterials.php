<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BuiCustomStructureMaterials
 *
 * @ORM\Table(name="bui_custom_structure_materials")
 * @ORM\Entity
 */
class BuiCustomStructureMaterials
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_csm", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCsm;

    /**
     * @var int|null
     *
     * @ORM\Column(name="structure_id_csm", type="bigint", nullable=true)
     */
    private $structureIdCsm;

    /**
     * @var int|null
     *
     * @ORM\Column(name="material_id_csm", type="bigint", nullable=true)
     */
    private $materialIdCsm;

    /**
     * @var string|null
     *
     * @ORM\Column(name="quantity_csm", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $quantityCsm;

    /**
     * @var int|null
     *
     * @ORM\Column(name="project_id_csm", type="bigint", nullable=true)
     */
    private $projectIdCsm;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_csm", type="smallint", nullable=true)
     */
    private $deletedCsm = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_csm", type="datetime", nullable=true)
     */
    private $createdonCsm;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_csm", type="bigint", nullable=true)
     */
    private $createdbyCsm;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_csm", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonCsm = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_csm", type="bigint", nullable=true)
     */
    private $editedbyCsm;


}
