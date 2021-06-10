<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MatMaterials
 *
 * @ORM\Table(name="mat_materials")
 * @ORM\Entity
 */
class MatMaterials
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_mat", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_mat", type="string", length=30, nullable=true)
     */
    private $codeMat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name_mat", type="text", length=65535, nullable=true)
     */
    private $nameMat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description_mat", type="text", length=65535, nullable=true)
     */
    private $descriptionMat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="unit_of_measurement_mat", type="string", length=20, nullable=true)
     */
    private $unitOfMeasurementMat;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_mat", type="smallint", nullable=true)
     */
    private $deletedMat = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_mat", type="datetime", nullable=true)
     */
    private $createdonMat;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_mat", type="bigint", nullable=true)
     */
    private $createdbyMat;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="editedon_mat", type="datetime", nullable=true, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonMat = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_mat", type="bigint", nullable=true)
     */
    private $editedbyMat;


}
