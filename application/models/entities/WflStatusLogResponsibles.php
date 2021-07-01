<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflStatusLogResponsibles
 *
 * @ORM\Table(name="wfl_status_log_responsibles", indexes={@ORM\Index(name="fk_status_log_id_slr", columns={"status_log_id_slr"}), @ORM\Index(name="fk_responsible_id_slr", columns={"responsible_id_slr"})})
 * @ORM\Entity
 */
class WflStatusLogResponsibles
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_slr", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSlr;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_slr", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedSlr;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_slr", type="datetime", nullable=true)
     */
    private $createdonSlr;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_slr", type="bigint", nullable=true)
     */
    private $createdbySlr;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_slr", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonSlr = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_slr", type="bigint", nullable=true)
     */
    private $editedbySlr;

    /**
     * @var \WflProjectStatusLog
     *
     * @ORM\ManyToOne(targetEntity="WflProjectStatusLog")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_log_id_slr", referencedColumnName="id_psl")
     * })
     */
    private $statusLogIdSlr;

    /**
     * @var \WflStatusResponsibles
     *
     * @ORM\ManyToOne(targetEntity="WflStatusResponsibles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="responsible_id_slr", referencedColumnName="id_sre")
     * })
     */
    private $responsibleIdSlr;


}
