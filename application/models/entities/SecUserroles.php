<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * SecUserroles
 *
 * @ORM\Table(name="sec_userroles", uniqueConstraints={@ORM\UniqueConstraint(name="UQ_sec_userroles_id_uro", columns={"id_uro"})}, indexes={@ORM\Index(name="roleid_uro", columns={"roleid_uro"}), @ORM\Index(name="userid_uro", columns={"userid_uro"})})
 * @ORM\Entity
 */
class SecUserroles
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_uro", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUro;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_uro", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedUro;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_uro", type="datetime", nullable=true)
     */
    private $createdonUro;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_uro", type="bigint", nullable=true)
     */
    private $createdbyUro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_uro", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonUro = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_uro", type="bigint", nullable=true)
     */
    private $editedbyUro;

    /**
     * @var \SecRoles
     *
     * @ORM\ManyToOne(targetEntity="SecRoles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="roleid_uro", referencedColumnName="id_rol")
     * })
     */
    private $roleidUro;

    /**
     * @var \SecUsers
     *
     * @ORM\ManyToOne(targetEntity="SecUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userid_uro", referencedColumnName="id_usr")
     * })
     */
    private $useridUro;


}
