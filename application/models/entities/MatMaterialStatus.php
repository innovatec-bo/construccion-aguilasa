<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MatMaterialStatus
 *
 * @ORM\Table(name="mat_material_status")
 * @ORM\Entity
 */
class MatMaterialStatus
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_mst", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMst;

    /**
     * @var string|null
     *
     * @ORM\Column(name="detail_mst", type="string", length=100, nullable=true)
     */
    private $detailMst;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_mst", type="string", length=20, nullable=true)
     */
    private $codeMst;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_mst", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedMst;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_mst", type="datetime", nullable=true)
     */
    private $createdonMst;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_mst", type="bigint", nullable=true)
     */
    private $createdbyMst;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_mst", type="datetime", nullable=true, options={"default"=null})
     */
    private $editedonMst = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_mst", type="bigint", nullable=true)
     */
    private $editedbyMst;


}
