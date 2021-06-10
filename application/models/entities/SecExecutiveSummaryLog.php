<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * SecExecutiveSummaryLog
 *
 * @ORM\Table(name="sec_executive_summary_log")
 * @ORM\Entity
 */
class SecExecutiveSummaryLog
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_esl", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEsl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="stage_esl", type="string", length=20, nullable=true)
     */
    private $stageEsl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="projects_quantity_esl", type="smallint", nullable=true)
     */
    private $projectsQuantityEsl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="project_percentage_esl", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $projectPercentageEsl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="approved_budget_esl", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $approvedBudgetEsl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="approved_budget_percentage_esl", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $approvedBudgetPercentageEsl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contract_percentage_esl", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $contractPercentageEsl;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_esl", type="datetime", nullable=true)
     */
    private $dateEsl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_esl", type="smallint", nullable=true)
     */
    private $deletedEsl = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_esl", type="datetime", nullable=true)
     */
    private $createdonEsl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_esl", type="bigint", nullable=true)
     */
    private $createdbyEsl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_esl", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonEsl = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_esl", type="bigint", nullable=true)
     */
    private $editedbyEsl;


}
