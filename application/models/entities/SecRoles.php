<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * SecRoles
 *
 * @ORM\Table(name="sec_roles", uniqueConstraints={@ORM\UniqueConstraint(name="UQ_sec_roles_id_rol", columns={"id_rol"})})
 * @ORM\Entity
 */
class SecRoles
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_rol", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRol;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rolename_rol", type="string", length=20, nullable=true)
     */
    private $rolenameRol;

    /**
     * @var string|null
     *
     * @ORM\Column(name="keyword_rol", type="string", length=30, nullable=true)
     */
    private $keywordRol;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_rol", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedRol;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_rol", type="datetime", nullable=true)
     */
    private $createdonRol;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_rol", type="bigint", nullable=true)
     */
    private $createdbyRol;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_rol", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonRol = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_rol", type="bigint", nullable=true)
     */
    private $editedbyRol;


}
