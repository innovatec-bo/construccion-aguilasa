<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * SecUserSupervisorByPeriod
 *
 * @ORM\Table(name="sec_user_supervisor_by_period", indexes={@ORM\Index(name="fk_supervisor_id_usp", columns={"supervisor_id_usp"}), @ORM\Index(name="fk_user_id_usp", columns={"user_id_usp"})})
 * @ORM\Entity
 */
class SecUserSupervisorByPeriod
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_usp", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUsp;

    /**
     * @var int|null
     *
     * @ORM\Column(name="user_id_usp", type="bigint", nullable=true)
     */
    private $userIdUsp;

    /**
     * @var int|null
     *
     * @ORM\Column(name="supervisor_id_usp", type="bigint", nullable=true)
     */
    private $supervisorIdUsp;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="from_usp", type="datetime", nullable=true)
     */
    private $fromUsp;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="to_usp", type="datetime", nullable=true)
     */
    private $toUsp;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_usp", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedUsp;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_usp", type="datetime", nullable=true)
     */
    private $createdonUsp;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_usp", type="bigint", nullable=true)
     */
    private $createdbyUsp;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="editedon_usp", type="datetime", nullable=true, options={"default"=null})
     */
    private $editedonUsp = '2018-01-01 02:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_usp", type="bigint", nullable=true)
     */
    private $editedbyUsp;


}
