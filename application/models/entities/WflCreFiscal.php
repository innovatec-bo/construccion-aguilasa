<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflCreFiscal
 *
 * @ORM\Table(name="wfl_cre_fiscal")
 * @ORM\Entity
 */
class WflCreFiscal
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_cfi", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCfi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="firstname_cfi", type="string", length=30, nullable=true)
     */
    private $firstnameCfi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lastname_cfi", type="string", length=30, nullable=true)
     */
    private $lastnameCfi;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_cfi", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedCfi;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_cfi", type="datetime", nullable=true)
     */
    private $createdonCfi;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_cfi", type="bigint", nullable=true)
     */
    private $createdbyCfi;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_cfi", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonCfi = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_cfi", type="bigint", nullable=true)
     */
    private $editedbyCfi;


}
