<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BuiLaborCostLog
 *
 * @ORM\Table(name="bui_labor_cost_log")
 * @ORM\Entity
 */
class BuiLaborCostLog
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_lal", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLal;

    /**
     * @var int|null
     *
     * @ORM\Column(name="user_id_lal", type="bigint", nullable=true)
     */
    private $userIdLal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="detail_lal", type="text", length=65535, nullable=true)
     */
    private $detailLal;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="manual_entry_date_lal", type="datetime", nullable=true)
     */
    private $manualEntryDateLal;

    /**
     * @var int|null
     *
     * @ORM\Column(name="point_id_lal", type="bigint", nullable=true)
     */
    private $pointIdLal;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_lal", type="smallint", nullable=true)
     */
    private $deletedLal = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_lal", type="datetime", nullable=true)
     */
    private $createdonLal;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_lal", type="bigint", nullable=true)
     */
    private $createdbyLal;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_lal", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonLal = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_lal", type="bigint", nullable=true)
     */
    private $editedbyLal;


}
