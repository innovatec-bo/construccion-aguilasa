<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflTrackingList
 *
 * @ORM\Table(name="wfl_tracking_list")
 * @ORM\Entity
 */
class WflTrackingList
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_trl", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTrl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="list_name_trl", type="string", length=40, nullable=true)
     */
    private $listNameTrl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_list_trl", type="text", length=65535, nullable=true)
     */
    private $codeListTrl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_trl", type="smallint", nullable=true)
     */
    private $deletedTrl;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_trl", type="datetime", nullable=true)
     */
    private $createdonTrl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_trl", type="bigint", nullable=true)
     */
    private $createdbyTrl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_trl", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonTrl = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_trl", type="bigint", nullable=true)
     */
    private $editedbyTrl;


}
