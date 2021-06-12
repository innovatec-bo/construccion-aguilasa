<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflProjectStakes
 *
 * @ORM\Table(name="wfl_project_stakes", indexes={@ORM\Index(name="fk_stakes_leader_id_prs", columns={"stakes_leader_id_prs"}), @ORM\Index(name="fk_project_id_prs", columns={"project_id_prs"})})
 * @ORM\Entity
 */
class WflProjectStakes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_prs", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPrs;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_prs", type="smallint", nullable=true)
     */
    private $deletedPrs = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_prs", type="datetime", nullable=true)
     */
    private $createdonPrs;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_prs", type="bigint", nullable=true)
     */
    private $createdbyPrs;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_prs", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonPrs = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_prs", type="bigint", nullable=true)
     */
    private $editedbyPrs;

    /**
     * @var \WflProjects
     *
     * @ORM\ManyToOne(targetEntity="WflProjects")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id_prs", referencedColumnName="id_pro")
     * })
     */
    private $projectIdPrs;

    /**
     * @var \WflStakesTeamLeader
     *
     * @ORM\ManyToOne(targetEntity="WflStakesTeamLeader")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="stakes_leader_id_prs", referencedColumnName="id_stl")
     * })
     */
    private $stakesLeaderIdPrs;


}
