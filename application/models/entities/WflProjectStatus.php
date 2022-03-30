<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflProjectStatus
 *
 * @ORM\Table(name="wfl_project_status", uniqueConstraints={@ORM\UniqueConstraint(name="UQ_sec_roles_id_rol", columns={"id_pst"})})
 * @ORM\Entity
 */
class WflProjectStatus
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_pst", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPst;

    /**
     * @var string|null
     *
     * @ORM\Column(name="status_name_pst", type="string", length=50, nullable=true)
     */
    private $statusNamePst;

    /**
     * @var string|null
     *
     * @ORM\Column(name="status_icon_pst", type="string", length=50, nullable=true)
     */
    private $statusIconPst;

    /**
     * @var int|null
     *
     * @ORM\Column(name="order_pst", type="smallint", nullable=true)
     */
    private $orderPst;

    /**
     * @var int|null
     *
     * @ORM\Column(name="parent_status_pst", type="bigint", nullable=true)
     */
    private $parentStatusPst;

    /**
     * @var string|null
     *
     * @ORM\Column(name="keyword_pst", type="string", length=50, nullable=true)
     */
    private $keywordPst;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_pst", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedPst;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_pst", type="datetime", nullable=true)
     */
    private $createdonPst;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_pst", type="bigint", nullable=true)
     */
    private $createdbyPst;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_pst", type="datetime", nullable=true, options={"default"=null})
     */
    private $editedonPst = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_pst", type="bigint", nullable=true)
     */
    private $editedbyPst;


}
