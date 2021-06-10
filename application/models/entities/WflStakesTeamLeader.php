<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflStakesTeamLeader
 *
 * @ORM\Table(name="wfl_stakes_team_leader")
 * @ORM\Entity
 */
class WflStakesTeamLeader
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_stl", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idStl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="leader_stl", type="string", length=20, nullable=true)
     */
    private $leaderStl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_stl", type="smallint", nullable=true)
     */
    private $deletedStl = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_stl", type="datetime", nullable=true)
     */
    private $createdonStl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_stl", type="bigint", nullable=true)
     */
    private $createdbyStl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_stl", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonStl = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_stl", type="bigint", nullable=true)
     */
    private $editedbyStl;


}
