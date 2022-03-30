<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflProcessLine
 *
 * @ORM\Table(name="wfl_process_line")
 * @ORM\Entity
 */
class WflProcessLine
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_prl", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPrl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="project_id_prl", type="bigint", nullable=true)
     */
    private $projectIdPrl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="user_id_prl", type="bigint", nullable=true)
     */
    private $userIdPrl;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="start_date_prl", type="datetime", nullable=true)
     */
    private $startDatePrl;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="due_date_prl", type="datetime", nullable=true)
     */
    private $dueDatePrl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="detail_prl", type="text", length=65535, nullable=true)
     */
    private $detailPrl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_prl", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedPrl;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_prl", type="datetime", nullable=true)
     */
    private $createdonPrl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_prl", type="bigint", nullable=true)
     */
    private $createdbyPrl;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="editedon_prl", type="datetime", nullable=true, options={"default"=null})
     */
    private $editedonPrl = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_prl", type="bigint", nullable=true)
     */
    private $editedbyPrl;


}
