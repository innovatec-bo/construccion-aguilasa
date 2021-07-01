<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * SecFeatures
 *
 * @ORM\Table(name="sec_features", uniqueConstraints={@ORM\UniqueConstraint(name="UQ_sec_features_id_fes", columns={"id_fes"})})
 * @ORM\Entity
 */
class SecFeatures
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_fes", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFes;

    /**
     * @var string|null
     *
     * @ORM\Column(name="featurename_fes", type="string", length=40, nullable=true)
     */
    private $featurenameFes;

    /**
     * @var string|null
     *
     * @ORM\Column(name="securitystring_fes", type="string", length=50, nullable=true)
     */
    private $securitystringFes;

    /**
     * @var string|null
     *
     * @ORM\Column(name="featureicon_fes", type="string", length=30, nullable=true)
     */
    private $featureiconFes;

    /**
     * @var string|null
     *
     * @ORM\Column(name="link_fes", type="string", length=70, nullable=true)
     */
    private $linkFes;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description_fes", type="text", length=65535, nullable=true)
     */
    private $descriptionFes;

    /**
     * @var int|null
     *
     * @ORM\Column(name="parent_feature_id_fes", type="bigint", nullable=true)
     */
    private $parentFeatureIdFes;

    /**
     * @var int|null
     *
     * @ORM\Column(name="order_fes", type="smallint", nullable=true)
     */
    private $orderFes;

    /**
     * @var int|null
     *
     * @ORM\Column(name="is_menu_fes", type="smallint", nullable=true, options={"default"="1"})
     */
    private $isMenuFes = '1';

    /**
     * @var int|null
     *
     * @ORM\Column(name="deleted_fes", type="smallint", nullable=true, options={"default"="0"})
     */
    private $deletedFes;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdon_fes", type="datetime", nullable=true)
     */
    private $createdonFes;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby_fes", type="bigint", nullable=true)
     */
    private $createdbyFes;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="editedon_fes", type="datetime", nullable=true, options={"default"="2018-01-01 01:00:00"})
     */
    private $editedonFes = '2018-01-01 01:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="editedby_fes", type="bigint", nullable=true)
     */
    private $editedbyFes;


}
