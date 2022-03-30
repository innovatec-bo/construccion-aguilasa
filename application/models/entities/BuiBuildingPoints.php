<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BuiBuildingPoints
 *
 * @ORM\Table(name="bui_building_points")
 * @ORM\Entity
 */
class BuiBuildingPoints
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_bpo", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idBpo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="project_id_bpo", type="bigint", nullable=true)
     */
    private $projectIdBpo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="label_bpo", type="string", length=30, nullable=true)
     */
    private $labelBpo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="latitude_bpo", type="string", length=30, nullable=true)
     */
    private $latitudeBpo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="longitude_bpo", type="string", length=30, nullable=true)
     */
    private $longitudeBpo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="previous_point_bpo", type="bigint", nullable=true)
     */
    private $previousPointBpo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="distance_bpo", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $distanceBpo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="angle_bpo", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $angleBpo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_bpo", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedBpo;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_bpo", type="datetime", nullable=true)
     */
    private $createdonBpo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_bpo", type="bigint", nullable=true)
     */
    private $createdbyBpo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedon_bpo", type="datetime", nullable=true, options={"default"=null})
     */
    private $editedonBpo = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_bpo", type="bigint", nullable=true)
     */
    private $editedbyBpo;


}
