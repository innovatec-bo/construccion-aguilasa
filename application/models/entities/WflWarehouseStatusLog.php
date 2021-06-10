<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflWarehouseStatusLog
 *
 * @ORM\Table(name="wfl_warehouse_status_log", indexes={@ORM\Index(name="fk_warehouse_id_wsl", columns={"warehouse_id_wsl"}), @ORM\Index(name="fk_status_id_wsl", columns={"status_id_wsl"})})
 * @ORM\Entity
 */
class WflWarehouseStatusLog
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_wsl", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idWsl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="log_detail_wsl", type="text", length=65535, nullable=true)
     */
    private $logDetailWsl;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="manual_entry_date_wsl", type="datetime", nullable=true)
     */
    private $manualEntryDateWsl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_wsl", type="smallint", nullable=true)
     */
    private $deletedWsl = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_wsl", type="datetime", nullable=true)
     */
    private $createdonWsl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_wsl", type="bigint", nullable=true)
     */
    private $createdbyWsl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_wsl", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonWsl = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_wsl", type="bigint", nullable=true)
     */
    private $editedbyWsl;

    /**
     * @var \WflProjects
     *
     * @ORM\ManyToOne(targetEntity="WflProjects")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="warehouse_id_wsl", referencedColumnName="id_pro")
     * })
     */
    private $warehouseIdWsl;

    /**
     * @var \WflProjectStatus
     *
     * @ORM\ManyToOne(targetEntity="WflProjectStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id_wsl", referencedColumnName="id_pst")
     * })
     */
    private $statusIdWsl;


}
