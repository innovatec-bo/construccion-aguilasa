<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflWorkflowColumnGroups
 *
 * @ORM\Table(name="wfl_workflow_column_groups")
 * @ORM\Entity
 */
class WflWorkflowColumnGroups
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_wcg", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idWcg;

    /**
     * @var string|null
     *
     * @ORM\Column(name="column_group_name_wcg", type="string", length=20, nullable=true)
     */
    private $columnGroupNameWcg;

    /**
     * @var string|null
     *
     * @ORM\Column(name="column_list_wcg", type="text", length=65535, nullable=true)
     */
    private $columnListWcg;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_wcg", type="smallint", nullable=true)
     */
    private $deletedWcg = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_wcg", type="datetime", nullable=true)
     */
    private $createdonWcg;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_wcg", type="bigint", nullable=true)
     */
    private $createdbyWcg;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_wcg", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonWcg = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_wcg", type="bigint", nullable=true)
     */
    private $editedbyWcg;


}
