<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflStatusResponsibles
 *
 * @ORM\Table(name="wfl_status_responsibles", indexes={@ORM\Index(name="fk_user_id_sre", columns={"user_id_sre"}), @ORM\Index(name="fk_status_id_sre", columns={"status_id_sre"})})
 * @ORM\Entity
 */
class WflStatusResponsibles
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_sre", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSre;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_sre", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedSre;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_sre", type="datetime", nullable=true)
     */
    private $createdonSre;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_sre", type="bigint", nullable=true)
     */
    private $createdbySre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_sre", type="datetime", nullable=true, options={"default"=null})
     */
    private $editedonSre = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_sre", type="bigint", nullable=true)
     */
    private $editedbySre;

    /**
     * @var \SecUsers
     *
     * @ORM\ManyToOne(targetEntity="SecUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id_sre", referencedColumnName="id_usr")
     * })
     */
    private $userIdSre;

    /**
     * @var \WflProjectStatus
     *
     * @ORM\ManyToOne(targetEntity="WflProjectStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id_sre", referencedColumnName="id_pst")
     * })
     */
    private $statusIdSre;


}
