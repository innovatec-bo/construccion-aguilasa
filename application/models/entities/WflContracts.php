<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflContracts
 *
 * @ORM\Table(name="wfl_contracts")
 * @ORM\Entity
 */
class WflContracts
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_con", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCon;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contract_number_con", type="string", length=20, nullable=true)
     */
    private $contractNumberCon;

    /**
     * @var float|null
     *
     * @ORM\Column(name="amount_con", type="float", precision=10, scale=0, nullable=true)
     */
    private $amountCon;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="start_date_con", type="datetime", nullable=true)
     */
    private $startDateCon;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="expiration_date_con", type="datetime", nullable=true)
     */
    private $expirationDateCon;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_con", type="smallint", nullable=true)
     */
    private $deletedCon;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_con", type="datetime", nullable=true)
     */
    private $createdonCon;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_con", type="bigint", nullable=true)
     */
    private $createdbyCon;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_con", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonCon = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_con", type="bigint", nullable=true)
     */
    private $editedbyCon;


}
