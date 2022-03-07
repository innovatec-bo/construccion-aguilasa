<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * 
 *
 * @ORM\Table(name="mat_internal_warehouse_operations")})
 * @ORM\Entity
 */
class MatInternalWarehouseOperation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_iwo", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idIwo;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="entry_date_iwo", type="datetime", nullable=true)
     */
    private $entryDateIwo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="detail_iwo", type="text", length=65535, nullable=true)
     */
    private $detailIwo;

    /**
     * @ORM\ManyToOne(targetEntity="MatInternalWarehouseOperationTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="operation_type_id_iwo", referencedColumnName="id_oty")
     * })
     */
    private $operationTypeId;

    /**
     * @ORM\ManyToOne(targetEntity="SecUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fiscal_id_iwo", referencedColumnName="id_usr")
     * })
     */
    private $fiscalId;

    /**
     * @ORM\ManyToOne(targetEntity="SecUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="builder_id_iwo", referencedColumnName="id_usr")
     * })
     */
    private $builderId;

    /**
     * @ORM\ManyToOne(targetEntity="WflProjects")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id_iwo", referencedColumnName="id_pro")
     * })
     */
    private $projectId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_iwo", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedIwo;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_iwo", type="datetime", nullable=true)
     */
    private $createdonIwo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_iwo", type="bigint", nullable=true)
     */
    private $createdbyIwo;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="editedon_iwo", type="datetime", nullable=true, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonMsu = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_iwo", type="bigint", nullable=true)
     */
    private $editedbyIwo;
}
