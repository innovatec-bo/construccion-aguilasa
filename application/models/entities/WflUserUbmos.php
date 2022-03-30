<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflUserUbmos
 *
 * @ORM\Table(name="wfl_user_ubmos")
 * @ORM\Entity
 */
class WflUserUbmos
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_uub", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUub;

    /**
     * @var int|null
     *
     * @ORM\Column(name="user_id_uub", type="bigint", nullable=true)
     */
    private $userIdUub;

    /**
     * @var int|null
     *
     * @ORM\Column(name="contract_id_uub", type="bigint", nullable=true)
     */
    private $contractIdUub;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ubmo_uub", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $ubmoUub;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bs_uub", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $bsUub;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_uub", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedUub;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_uub", type="datetime", nullable=true)
     */
    private $createdonUub;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_uub", type="bigint", nullable=true)
     */
    private $createdbyUub;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="editedon_uub", type="datetime", nullable=true, options={"default"=null})
     */
    private $editedonUub = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_uub", type="bigint", nullable=true)
     */
    private $editedbyUub;


}
