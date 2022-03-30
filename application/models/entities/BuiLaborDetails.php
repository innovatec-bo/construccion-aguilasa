<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BuiLaborDetails
 *
 * @ORM\Table(name="bui_labor_details")
 * @ORM\Entity
 */
class BuiLaborDetails
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_lad", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLad;

    /**
     * @var int|null
     *
     * @ORM\Column(name="project_id_lad", type="bigint", nullable=true)
     */
    private $projectIdLad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="graph_number_lad", type="string", length=20, nullable=true)
     */
    private $graphNumberLad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="level_of_tension_lad", type="string", length=20, nullable=true)
     */
    private $levelOfTensionLad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="destiny_lad", type="text", length=65535, nullable=true)
     */
    private $destinyLad;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_lad", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedLad;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_lad", type="datetime", nullable=true)
     */
    private $createdonLad;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_lad", type="bigint", nullable=true)
     */
    private $createdbyLad;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_lad", type="datetime", nullable=true, options={"default"=null})
     */
    private $editedonLad = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_lad", type="bigint", nullable=true)
     */
    private $editedbyLad;


}
