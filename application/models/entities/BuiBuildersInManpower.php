<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BuiBuildersInManpower
 *
 * @ORM\Table(name="bui_builders_in_manpower")
 * @ORM\Entity
 */
class BuiBuildersInManpower
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_bim", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idBim;

    /**
     * @var int|null
     *
     * @ORM\Column(name="labor_cost_log_id_bim", type="bigint", nullable=true)
     */
    private $laborCostLogIdBim;

    /**
     * @var int|null
     *
     * @ORM\Column(name="user_id_bim", type="bigint", nullable=true)
     */
    private $userIdBim;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_bim", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedBim;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_bim", type="datetime", nullable=true)
     */
    private $createdonBim;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_bim", type="bigint", nullable=true)
     */
    private $createdbyBim;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_bim", type="datetime", nullable=true, options={"default"=null})
     */
    private $editedonBim = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_bim", type="bigint", nullable=true)
     */
    private $editedbyBim;


}
