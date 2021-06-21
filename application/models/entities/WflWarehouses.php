<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflWarehouses
 *
 * @ORM\Table(name="wfl_warehouses", indexes={@ORM\Index(name="fk_project_id_war", columns={"project_id_war"}), @ORM\Index(name="fk_status_id_war", columns={"status_id_war"})})
 * @ORM\Entity
 */
class WflWarehouses
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_war", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idWar;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_war", type="smallint", nullable=true)
     */
    private $deletedWar;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_war", type="datetime", nullable=true)
     */
    private $createdonWar;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_war", type="bigint", nullable=true)
     */
    private $createdbyWar;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_war", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonWar = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_war", type="bigint", nullable=true)
     */
    private $editedbyWar;

    /**
     * @var \WflProjectStatus
     *
     * @ORM\ManyToOne(targetEntity="WflProjectStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id_war", referencedColumnName="id_pst")
     * })
     */
    private $statusIdWar;

    /**
     * @var \WflProjects
     *
     * @ORM\ManyToOne(targetEntity="WflProjects")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id_war", referencedColumnName="id_pro")
     * })
     */
    private $projectIdWar;


}
