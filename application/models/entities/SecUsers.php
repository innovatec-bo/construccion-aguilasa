<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * SecUsers
 *
 * @ORM\Table(name="sec_users", uniqueConstraints={@ORM\UniqueConstraint(name="UQ_sec_users_id_usr", columns={"id_usr"})})
 * @ORM\Entity
 */
class SecUsers
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_usr", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUsr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="firstname_usr", type="string", length=40, nullable=true)
     */
    private $firstnameUsr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lastname_usr", type="string", length=40, nullable=true)
     */
    private $lastnameUsr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email_usr", type="string", length=40, nullable=true)
     */
    private $emailUsr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="facebookid_usr", type="string", length=40, nullable=true)
     */
    private $facebookidUsr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone_usr", type="string", length=20, nullable=true)
     */
    private $phoneUsr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password_usr", type="text", length=65535, nullable=true)
     */
    private $passwordUsr;

    /**
     * @var int|null
     *
     * @ORM\Column(name="avatar_usr", type="bigint", nullable=true)
     */
    private $avatarUsr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="passwordhash_usr", type="text", length=65535, nullable=true)
     */
    private $passwordhashUsr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="activationhash_usr", type="text", length=65535, nullable=true)
     */
    private $activationhashUsr;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status_usr", type="smallint", nullable=true)
     */
    private $statusUsr;

    /**
     * @var int|null
     *
     * @ORM\Column(name="tax_deductible_usr", type="smallint", nullable=true)
     */
    private $taxDeductibleUsr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="googleid_usr", type="string", length=40, nullable=true)
     */
    private $googleidUsr;

    /**
     * @var int|null
     *
     * @ORM\Column(name="supervising_user_usr", type="bigint", nullable=true)
     */
    private $supervisingUserUsr;

    /**
     * @var float|null
     *
     * @ORM\Column(name="umbo_usr", type="float", precision=10, scale=0, nullable=true)
     */
    private $umboUsr;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_usr", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedUsr;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_usr", type="datetime", nullable=true)
     */
    private $createdonUsr;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_usr", type="bigint", nullable=true)
     */
    private $createdbyUsr;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_usr", type="datetime", nullable=true, options={"default"=null})
     */
    private $editedonUsr = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_usr", type="bigint", nullable=true)
     */
    private $editedbyUsr;


}
