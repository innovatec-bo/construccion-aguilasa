<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MatProjectsMaterials
 *
 * @ORM\Table(name="mat_projects_materials", indexes={@ORM\Index(name="fk_status_id_prm", columns={"status_id_prm"}), @ORM\Index(name="fk_material_id_prm", columns={"material_id_prm"}), @ORM\Index(name="fk_materials_summary_id_prm", columns={"materials_summary_id_prm"})})
 * @ORM\Entity
 */
class MatProjectsMaterials
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_prm", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPrm;

    /**
     * @var int|null
     *
     * @ORM\Column(name="materials_summary_id_prm", type="bigint", nullable=true)
     */
    private $materialsSummaryIdPrm;

    /**
     * @var int|null
     *
     * @ORM\Column(name="material_id_prm", type="bigint", nullable=true)
     */
    private $materialIdPrm;

    /**
     * @var string|null
     *
     * @ORM\Column(name="quantity_prm", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $quantityPrm;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status_id_prm", type="bigint", nullable=true)
     */
    private $statusIdPrm;

    /**
     * @var int|null
     *
     * @ORM\Column(name="tension_id_prm", type="smallint", nullable=true)
     */
    private $tensionIdPrm;

    /**
     * @var string|null
     *
     * @ORM\Column(name="request_cre_pto_prm", type="text", length=65535, nullable=true)
     */
    private $requestCrePtoPrm;

    /**
     * @var string|null
     *
     * @ORM\Column(name="request_cre_detail_prm", type="text", length=65535, nullable=true)
     */
    private $requestCreDetailPrm;

    /**
     * @var string|null
     *
     * @ORM\Column(name="delivered_to_builder_detail_prm", type="text", length=65535, nullable=true)
     */
    private $deliveredToBuilderDetailPrm;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_prm", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedPrm;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_prm", type="datetime", nullable=true)
     */
    private $createdonPrm;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_prm", type="bigint", nullable=true)
     */
    private $createdbyPrm;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="editedon_prm", type="datetime", nullable=true, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonPrm = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_prm", type="bigint", nullable=true)
     */
    private $editedbyPrm;


}
