<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BuiBlockedLogDateRanges
 *
 * @ORM\Table(name="bui_blocked_log_date_ranges")
 * @ORM\Entity
 */
class BuiBlockedLogDateRanges
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_bld", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idBld;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="from_bld", type="datetime", nullable=true)
     */
    private $fromBld;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="to_bld", type="datetime", nullable=true)
     */
    private $toBld;

    /**
     * @var string|null
     *
     * @ORM\Column(name="deleted_by_bld", type="string", length=255, nullable=true)
     */
    private $deletedByBld;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_bld", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedBld;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_bld", type="datetime", nullable=true)
     */
    private $createdonBld;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_bld", type="bigint", nullable=true)
     */
    private $createdbyBld;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_bld", type="datetime", nullable=true, options={"default"=null})
     */
    private $editedonBld = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_bld", type="bigint", nullable=true)
     */
    private $editedbyBld;


}
