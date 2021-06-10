<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MatMaterialsSummaryTypes
 *
 * @ORM\Table(name="mat_materials_summary_types")
 * @ORM\Entity
 */
class MatMaterialsSummaryTypes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_mqt", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMqt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name_mqt", type="string", length=50, nullable=true)
     */
    private $nameMqt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="keyword_mqt", type="string", length=50, nullable=true)
     */
    private $keywordMqt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="icon_mqt", type="string", length=60, nullable=true)
     */
    private $iconMqt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="movement_type_mqt", type="string", length=30, nullable=true)
     */
    private $movementTypeMqt;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_mqt", type="smallint", nullable=true)
     */
    private $deletedMqt = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_mqt", type="datetime", nullable=true)
     */
    private $createdonMqt;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_mqt", type="bigint", nullable=true)
     */
    private $createdbyMqt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_mqt", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonMqt = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_mqt", type="bigint", nullable=true)
     */
    private $editedbyMqt;


}
