<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflProjects
 *
 * @ORM\Table(name="wfl_projects", uniqueConstraints={@ORM\UniqueConstraint(name="UQ_sec_roles_id_rol", columns={"id_pro"})}, indexes={@ORM\Index(name="fk_status_pro", columns={"status_pro"}), @ORM\Index(name="fk_contract_id_pro", columns={"contract_id_pro"})})
 * @ORM\Entity
 */
class WflProjects
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_pro", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPro;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_pro", type="string", length=15, nullable=true)
     */
    private $codePro;

    /**
     * @var string|null
     *
     * @ORM\Column(name="project_name_pro", type="string", length=100, nullable=true)
     */
    private $projectNamePro;

    /**
     * @var int|null
     *
     * @ORM\Column(name="system_pro", type="bigint", nullable=true)
     */
    private $systemPro;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address_pro", type="string", length=50, nullable=true)
     */
    private $addressPro;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="entry_date_pro", type="datetime", nullable=true)
     */
    private $entryDatePro;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cre_fiscal_pro", type="bigint", nullable=true)
     */
    private $creFiscalPro;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="project_start_pro", type="datetime", nullable=true)
     */
    private $projectStartPro;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="project_end_pro", type="datetime", nullable=true)
     */
    private $projectEndPro;

    /**
     * @var int|null
     *
     * @ORM\Column(name="points_pro", type="smallint", nullable=true)
     */
    private $pointsPro;

    /**
     * @var float|null
     *
     * @ORM\Column(name="distance_pro", type="float", precision=10, scale=0, nullable=true)
     */
    private $distancePro;

    /**
     * @var int|null
     *
     * @ORM\Column(name="management_by_pro", type="bigint", nullable=true)
     */
    private $managementByPro;

    /**
     * @var int|null
     *
     * @ORM\Column(name="quality_level_pro", type="smallint", nullable=true)
     */
    private $qualityLevelPro;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="cre_design_completion_date_pro", type="datetime", nullable=true)
     */
    private $creDesignCompletionDatePro;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="cre_building_completion_date_pro", type="datetime", nullable=true)
     */
    private $creBuildingCompletionDatePro;

    /**
     * @var int|null
     *
     * @ORM\Column(name="budgetary_position_pro", type="integer", nullable=true)
     */
    private $budgetaryPositionPro;

    /**
     * @var string|null
     *
     * @ORM\Column(name="secondary_code_pro", type="string", length=15, nullable=true)
     */
    private $secondaryCodePro;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="folder_date_pro", type="datetime", nullable=true)
     */
    private $folderDatePro;

    /**
     * @var string|null
     *
     * @ORM\Column(name="detail_pro", type="text", length=65535, nullable=true)
     */
    private $detailPro;

    /**
     * @var int|null
     *
     * @ORM\Column(name="energized_pro", type="smallint", nullable=true)
     */
    private $energizedPro;

    /**
     * @var int|null
     *
     * @ORM\Column(name="project_percentage_pro", type="integer", nullable=true)
     */
    private $projectPercentagePro;

    /**
     * @var string|null
     *
     * @ORM\Column(name="latitude_pro", type="string", length=50, nullable=true)
     */
    private $latitudePro;

    /**
     * @var string|null
     *
     * @ORM\Column(name="longitude_pro", type="string", length=50, nullable=true)
     */
    private $longitudePro;

    /**
     * @var string|null
     *
     * @ORM\Column(name="work_area_pro", type="string", length=20, nullable=true)
     */
    private $workAreaPro;

    /**
     * @var string|null
     *
     * @ORM\Column(name="project_year_pro", type="string", length=10, nullable=true)
     */
    private $projectYearPro;

    /**
     * @var int|null
     *
     * @ORM\Column(name="end_contract_pro", type="bigint", nullable=true)
     */
    private $endContractPro;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_pro", type="smallint", nullable=true)
     */
    private $deletedPro;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_pro", type="datetime", nullable=true)
     */
    private $createdonPro;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_pro", type="bigint", nullable=true)
     */
    private $createdbyPro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_pro", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonPro = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_pro", type="bigint", nullable=true)
     */
    private $editedbyPro;

    /**
     * @var \WflProjectStatus
     *
     * @ORM\ManyToOne(targetEntity="WflProjectStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_pro", referencedColumnName="id_pst")
     * })
     */
    private $statusPro;

    /**
     * @var \WflContracts
     *
     * @ORM\ManyToOne(targetEntity="WflContracts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contract_id_pro", referencedColumnName="id_con")
     * })
     */
    private $contractIdPro;


}
