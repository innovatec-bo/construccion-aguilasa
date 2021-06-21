<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflPaymentOrdersStatusLog
 *
 * @ORM\Table(name="wfl_payment_orders_status_log", indexes={@ORM\Index(name="fk_payment_order_id_pos", columns={"payment_order_id_pos"}), @ORM\Index(name="fk_status_id_pos", columns={"status_id_pos"})})
 * @ORM\Entity
 */
class WflPaymentOrdersStatusLog
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_pos", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPos;

    /**
     * @var string|null
     *
     * @ORM\Column(name="log_detail_pos", type="text", length=65535, nullable=true)
     */
    private $logDetailPos;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="manual_entry_date_pos", type="datetime", nullable=true)
     */
    private $manualEntryDatePos;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_pos", type="smallint", nullable=true)
     */
    private $deletedPos;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_pos", type="datetime", nullable=true)
     */
    private $createdonPos;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_pos", type="bigint", nullable=true)
     */
    private $createdbyPos;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="editedon_pos", type="datetime", nullable=true)
     */
    private $editedonPos;

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_pos", type="bigint", nullable=true)
     */
    private $editedbyPos;

    /**
     * @var \WflProjectStatus
     *
     * @ORM\ManyToOne(targetEntity="WflProjectStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id_pos", referencedColumnName="id_pst")
     * })
     */
    private $statusIdPos;

    /**
     * @var \WflPaymentOrders
     *
     * @ORM\ManyToOne(targetEntity="WflPaymentOrders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payment_order_id_pos", referencedColumnName="id_pao")
     * })
     */
    private $paymentOrderIdPos;


}
