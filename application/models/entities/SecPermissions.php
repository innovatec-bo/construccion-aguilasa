<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * SecPermissions
 *
 * @ORM\Table(name="sec_permissions", uniqueConstraints={@ORM\UniqueConstraint(name="UQ_sec_permissions_id_per", columns={"id_per"})}, indexes={@ORM\Index(name="featureid_per", columns={"featureid_per"}), @ORM\Index(name="roleid_per", columns={"roleid_per"})})
 * @ORM\Entity
 */
class SecPermissions
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_per", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPer;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_per", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedPer;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_per", type="datetime", nullable=true)
     */
    private $createdonPer;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_per", type="bigint", nullable=true)
     */
    private $createdbyPer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_per", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonPer = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_per", type="bigint", nullable=true)
     */
    private $editedbyPer;

    /**
     * @var \SecFeatures
     *
     * @ORM\ManyToOne(targetEntity="SecFeatures")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="featureid_per", referencedColumnName="id_fes")
     * })
     */
    private $featureidPer;

    /**
     * @var \SecRoles
     *
     * @ORM\ManyToOne(targetEntity="SecRoles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="roleid_per", referencedColumnName="id_rol")
     * })
     */
    private $roleidPer;


}
