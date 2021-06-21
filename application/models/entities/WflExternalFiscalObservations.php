<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WflExternalFiscalObservations
 *
 * @ORM\Table(name="wfl_external_fiscal_observations", indexes={@ORM\Index(name="fk_fixed_by_efo", columns={"fixed_by_efo"}), @ORM\Index(name="fk_status_id_efo", columns={"status_id_efo"}), @ORM\Index(name="fk_project_id_efo", columns={"project_id_efo"}), @ORM\Index(name="fk_fiscal_id_efo", columns={"fiscal_id_efo"})})
 * @ORM\Entity
 */
class WflExternalFiscalObservations
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_efo", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEfo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="project_id_efo", type="bigint", nullable=true)
     */
    private $projectIdEfo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="fiscal_id_efo", type="bigint", nullable=true)
     */
    private $fiscalIdEfo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observation_efo", type="text", length=65535, nullable=true)
     */
    private $observationEfo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="fixed_by_efo", type="bigint", nullable=true)
     */
    private $fixedByEfo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fix_detail_efo", type="text", length=65535, nullable=true)
     */
    private $fixDetailEfo;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fixed_date_efo", type="datetime", nullable=true)
     */
    private $fixedDateEfo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status_id_efo", type="bigint", nullable=true)
     */
    private $statusIdEfo;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="entry_date_efo", type="datetime", nullable=true)
     */
    private $entryDateEfo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="fixed_efo", type="smallint", nullable=true)
     */
    private $fixedEfo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_efo", type="smallint", nullable=true)
     */
    private $deletedEfo;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_efo", type="datetime", nullable=true)
     */
    private $createdonEfo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_efo", type="bigint", nullable=true)
     */
    private $createdbyEfo;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="editedon_efo", type="datetime", nullable=true, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonEfo = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_efo", type="bigint", nullable=true)
     */
    private $editedbyEfo;


}
