<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflPaymentOrders
 *
 * @ORM\Table(name="wfl_payment_orders")
 * @ORM\Entity
 */
class WflPaymentOrders
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_pao", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPao;

    /**
     * @var string|null
     *
     * @ORM\Column(name="order_number_pao", type="string", length=20, nullable=true)
     */
    private $orderNumberPao;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status_pao", type="smallint", nullable=true)
     */
    private $statusPao;

    /**
     * @var string|null
     *
     * @ORM\Column(name="invoice_number_pao", type="text", length=65535, nullable=true)
     */
    private $invoiceNumberPao;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="entry_date_pao", type="datetime", nullable=true)
     */
    private $entryDatePao;

    /**
     * @var string|null
     *
     * @ORM\Column(name="detail_pao", type="text", length=65535, nullable=true)
     */
    private $detailPao;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="invoice_date_pao", type="datetime", nullable=true)
     */
    private $invoiceDatePao;

    /**
     * @var int|null
     *
     * @ORM\Column(name="end_contract_id_pao", type="bigint", nullable=true)
     */
    private $endContractIdPao;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_pao", type="smallint", nullable=true)
     */
    private $deletedPao;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_pao", type="datetime", nullable=true)
     */
    private $createdonPao;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_pao", type="bigint", nullable=true)
     */
    private $createdbyPao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_pao", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonPao = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_pao", type="bigint", nullable=true)
     */
    private $editedbyPao;


}
