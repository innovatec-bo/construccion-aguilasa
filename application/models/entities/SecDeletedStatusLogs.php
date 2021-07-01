<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * SecDeletedStatusLogs
 *
 * @ORM\Table(name="sec_deleted_status_logs")
 * @ORM\Entity
 */
class SecDeletedStatusLogs
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_dsl", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDsl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_by_dsl", type="bigint", nullable=true)
     */
    private $deletedByDsl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status_log_id_dsl", type="bigint", nullable=true)
     */
    private $statusLogIdDsl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="detail_dsl", type="text", length=65535, nullable=true)
     */
    private $detailDsl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_dsl", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedDsl;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_dsl", type="datetime", nullable=true)
     */
    private $createdonDsl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_dsl", type="bigint", nullable=true)
     */
    private $createdbyDsl;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="editedon_dsl", type="datetime", nullable=true, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonDsl = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_dsl", type="bigint", nullable=true)
     */
    private $editedbyDsl;


}
