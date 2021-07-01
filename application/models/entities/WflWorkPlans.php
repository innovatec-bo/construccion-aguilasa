<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflWorkPlans
 *
 * @ORM\Table(name="wfl_work_plans")
 * @ORM\Entity
 */
class WflWorkPlans
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_wpl", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idWpl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title_wpl", type="text", length=65535, nullable=true)
     */
    private $titleWpl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="fiscal_id_wpl", type="bigint", nullable=true)
     */
    private $fiscalIdWpl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="builder_id_wpl", type="bigint", nullable=true)
     */
    private $builderIdWpl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="week_number_wpl", type="smallint", nullable=true)
     */
    private $weekNumberWpl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_wpl", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedWpl;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_wpl", type="datetime", nullable=true)
     */
    private $createdonWpl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_wpl", type="bigint", nullable=true)
     */
    private $createdbyWpl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_wpl", type="datetime", nullable=false)
     */
    private $editedonWpl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_wpl", type="bigint", nullable=true)
     */
    private $editedbyWpl;


}
