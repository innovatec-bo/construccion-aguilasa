<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MatMaterialsSummary
 *
 * @ORM\Table(name="mat_materials_summary", indexes={@ORM\Index(name="fk_parent_summary_id_msu", columns={"parent_summary_id_msu"}), @ORM\Index(name="fk_project_id_msu", columns={"project_id_msu"}), @ORM\Index(name="fk_project_status_log_id_msu", columns={"project_status_log_id_msu"}), @ORM\Index(name="fk_applicant_project_id_msu", columns={"applicant_project_id_msu"}), @ORM\Index(name="fk_summary_type_id_msu", columns={"summary_type_id_msu"})})
 * @ORM\Entity
 */
class MatMaterialsSummary
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_msu", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMsu;

    /**
     * @var int|null
     *
     * @ORM\Column(name="project_status_log_id_msu", type="bigint", nullable=true)
     */
    private $projectStatusLogIdMsu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tension_level_msu", type="string", length=50, nullable=true)
     */
    private $tensionLevelMsu;

    /**
     * @var int|null
     *
     * @ORM\Column(name="project_id_msu", type="bigint", nullable=true)
     */
    private $projectIdMsu;

    /**
     * @var int|null
     *
     * @ORM\Column(name="applicant_project_id_msu", type="bigint", nullable=true)
     */
    private $applicantProjectIdMsu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="graph_number_msu", type="string", length=30, nullable=true)
     */
    private $graphNumberMsu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="destiny_msu", type="string", length=100, nullable=true)
     */
    private $destinyMsu;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="entry_date_msu", type="datetime", nullable=true)
     */
    private $entryDateMsu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="detail_msu", type="text", length=65535, nullable=true)
     */
    private $detailMsu;

    /**
     * @var int|null
     *
     * @ORM\Column(name="builder_responsible_msu", type="bigint", nullable=true)
     */
    private $builderResponsibleMsu;

    /**
     * @var int|null
     *
     * @ORM\Column(name="summary_type_id_msu", type="bigint", nullable=true)
     */
    private $summaryTypeIdMsu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="reservation_number_msu", type="string", length=30, nullable=true)
     */
    private $reservationNumberMsu;

    /**
     * @var int|null
     *
     * @ORM\Column(name="file_id_msu", type="bigint", nullable=true)
     */
    private $fileIdMsu;

    /**
     * @var int|null
     *
     * @ORM\Column(name="parent_summary_id_msu", type="bigint", nullable=true)
     */
    private $parentSummaryIdMsu;

    /**
     * @var int|null
     *
     * @ORM\Column(name="is_loan_msu", type="smallint", nullable=true)
     */
    private $isLoanMsu = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="loan_closed_msu", type="smallint", nullable=true)
     */
    private $loanClosedMsu;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="loan_closed_date_msu", type="datetime", nullable=true)
     */
    private $loanClosedDateMsu;

    /**
     * @var int|null
     *
     * @ORM\Column(name="correlative_counter_msu", type="integer", nullable=true)
     */
    private $correlativeCounterMsu;

    /**
     * @var int|null
     *
     * @ORM\Column(name="fiscal_responsible_msu", type="bigint", nullable=true)
     */
    private $fiscalResponsibleMsu;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_msu", type="smallint", nullable=true)
     */
    private $deletedMsu = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_msu", type="datetime", nullable=true)
     */
    private $createdonMsu;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_msu", type="bigint", nullable=true)
     */
    private $createdbyMsu;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="editedon_msu", type="datetime", nullable=true, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonMsu = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_msu", type="bigint", nullable=true)
     */
    private $editedbyMsu;


}
