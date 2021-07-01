<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflDatesToWork
 *
 * @ORM\Table(name="wfl_dates_to_work", indexes={@ORM\Index(name="fk_project_id_eve", columns={"project_id_wpl"})})
 * @ORM\Entity
 */
class WflDatesToWork
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_wpl", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idWpl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title_wpl", type="string", length=100, nullable=true)
     */
    private $titleWpl;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="work_date_wpl", type="date", nullable=true)
     */
    private $workDateWpl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="detail_wpl", type="text", length=65535, nullable=true)
     */
    private $detailWpl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_wpl", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedWpl;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_wpl", type="datetime", nullable=true)
     */
    private $createdonWpl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_wpl", type="bigint", nullable=true)
     */
    private $createdbyWpl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_wpl", type="datetime", nullable=false)
     */
    private $editedonWpl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_wpl", type="bigint", nullable=true)
     */
    private $editedbyWpl;

    /**
     * @var \WflProjects
     *
     * @ORM\ManyToOne(targetEntity="WflProjects")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id_wpl", referencedColumnName="id_pro")
     * })
     */
    private $projectIdWpl;


}
