<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BuiPointToPointMaster
 *
 * @ORM\Table(name="bui_point_to_point_master")
 * @ORM\Entity
 */
class BuiPointToPointMaster
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_ptp", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPtp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="project_code_ptp", type="string", length=20, nullable=true)
     */
    private $projectCodePtp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="point_ptp", type="string", length=15, nullable=true)
     */
    private $pointPtp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="latitude_ptp", type="string", length=30, nullable=true)
     */
    private $latitudePtp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="longitude_ptp", type="string", length=30, nullable=true)
     */
    private $longitudePtp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="reg_ptp", type="string", length=5, nullable=true)
     */
    private $regPtp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="previous_point_ptp", type="string", length=15, nullable=true)
     */
    private $previousPointPtp;

    /**
     * @var float|null
     *
     * @ORM\Column(name="distance_at_ptp", type="float", precision=10, scale=0, nullable=true)
     */
    private $distanceAtPtp;

    /**
     * @var float|null
     *
     * @ORM\Column(name="angle_at_ptp", type="float", precision=10, scale=0, nullable=true)
     */
    private $angleAtPtp;

    /**
     * @var float|null
     *
     * @ORM\Column(name="distance_mt_ptp", type="float", precision=10, scale=0, nullable=true)
     */
    private $distanceMtPtp;

    /**
     * @var float|null
     *
     * @ORM\Column(name="angle_mt_ptp", type="float", precision=10, scale=0, nullable=true)
     */
    private $angleMtPtp;

    /**
     * @var float|null
     *
     * @ORM\Column(name="distance_bt_ptp", type="float", precision=10, scale=0, nullable=true)
     */
    private $distanceBtPtp;

    /**
     * @var float|null
     *
     * @ORM\Column(name="angle_bt_ptp", type="float", precision=10, scale=0, nullable=true)
     */
    private $angleBtPtp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="activity_ptp", type="string", length=5, nullable=true)
     */
    private $activityPtp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="quantity_ptp", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $quantityPtp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="building_structure_code_ptp", type="string", length=10, nullable=true)
     */
    private $buildingStructureCodePtp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="execution_ptp", type="string", length=5, nullable=true)
     */
    private $executionPtp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="unit_of_measurement_ptp", type="string", length=15, nullable=true)
     */
    private $unitOfMeasurementPtp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="building_structure_detail_ptp", type="text", length=65535, nullable=true)
     */
    private $buildingStructureDetailPtp;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_ptp", type="smallint", nullable=true)
     */
    private $deletedPtp;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_ptp", type="datetime", nullable=true)
     */
    private $createdonPtp;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_ptp", type="bigint", nullable=true)
     */
    private $createdbyPtp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_ptp", type="datetime", nullable=false, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonPtp = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_ptp", type="bigint", nullable=true)
     */
    private $editedbyPtp;


}
