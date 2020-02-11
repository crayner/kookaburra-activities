<?php
/**
 * Created by PhpStorm.
 *
 * Kookaburra
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 23/11/2018
 * Time: 15:27
 */

namespace Kookaburra\Activities\Entity;

use App\Entity\Setting;
use App\Manager\EntityInterface;
use App\Manager\Traits\BooleanList;
use App\Provider\ProviderFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Kookaburra\SchoolAdmin\Entity\AcademicYear;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Action
 * @package Kookaburra\Activities\Entity
 * @ORM\Entity(repositoryClass="Kookaburra\Activities\Repository\ActivityRepository")
 * @ORM\Table(
 *     options={"auto_increment": 1},
 *     name="Activity",
 *     indexes={@ORM\Index(name="AcademicYear", columns={"academic_year"})},
 *     uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name", "academic_year"})})
 * @UniqueEntity({"name","academicYear"})
 */
class Activity implements EntityInterface
{
    use BooleanList;
    
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", columnDefinition="INT(8) UNSIGNED AUTO_INCREMENT")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "Y"})
     */
    private $active = 'Y';

    /**
     * @var AcademicYear|null
     * @ORM\ManyToOne(targetEntity="Kookaburra\SchoolAdmin\Entity\AcademicYear")
     * @ORM\JoinColumn(name="academic_year",referencedColumnName="id", nullable=false)
     */
    private $AcademicYear;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"comment": "Can a parent/student select this for registration?", "default": "Y"})
     * @Assert\Choice(callback="getBooleanList")
     */
    private $registration = 'Y';

    /**
     * @var string|null
     * @ORM\Column(length=40)
     * @Assert\NotBlank()
     * @Assert\Length(max=40)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=8, options={"default": "School"})
     * @Assert\Choice(callback="getProviderList")
     */
    private $provider = 'School';

    /**
     * @var array
     */
    private static $providerList = ['School', 'External'];

    /**
     * @var string|null
     * @ORM\Column(length=255, name="activity_type")
     * @ORM\Column(callback="getTypeList")
     */
    private $type;

    /**
     * @var array|null
     * @ORM\Column(type="simple_array", name="academic_year_term_list", nullable=true)
     */
    private $academicYearTermList;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date_immutable", name="listing_start", nullable=true)
     */
    private $listingStart;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date_immutable", name="listing_end", nullable=true)
     */
    private $listingEnd;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date_immutable", name="program_start", nullable=true, nullable=true)
     */
    private $programStart;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date_immutable", name="program_end", nullable=true)
     */
    private $programEnd;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var float|null
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     */
    private $payment;

    /**
     * @var string
     * @ORM\Column(length=9, name="payment_firmness", nullable=true, options={"default": "Finalised"})
     * @Assert\Choice(callback="getPaymentFirmnessList")
     */
    private $paymentFirmness = 'Finalised';

    /**
     * @var array
     */
    private static $paymentFirmnessList = ['Finalised', 'Estimated'];

    /**
     * @var string
     * @ORM\Column(length=24, name="payment_type", nullable=true, options={"default": "Entire Programme"})
     * @Assert\Choice(callback="getPaymentTypeList")
     */
    private $paymentType = 'Entire Programme';

    /**
     * @var array
     */
    private static $paymentTypeList = ['Entire Programme','Per Session','Per Week','Per Term'];

    /**
     * @var array|null
     * @ORM\Column(name="year_group_list", type="simple_array", nullable=true)
     */
    private $yearGroupList;

    /**
     * @var int
     * @ORM\Column(type="smallint", columnDefinition="INT(3) UNSIGNED", name="maxParticipants", options={"default": "0"})
     */
    private $maxParticipants = 0;

    /**
     * @var Collection|null
     * @ORM\OneToMany(targetEntity="Kookaburra\Activities\Entity\ActivityStaff", mappedBy="activity")
     */
    private $staff;

    /**
     * @var Collection|null
     * @ORM\OneToMany(targetEntity="Kookaburra\Activities\Entity\ActivityStudent", mappedBy="activity")
     */
    private $students;

    /**
     * @return array
     */
    public static function getPaymentFirmnessList(): array
    {
        return self::$paymentFirmnessList;
    }

    /**
     * @return array
     */
    public static function getPaymentTypeList(): array
    {
        return self::$paymentTypeList;
    }

    /**
     * @return array
     */
    public static function getProviderList(): array
    {
        return self::$providerList;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Activity
     */
    public function setId(?int $id): Activity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return AcademicYear|null
     */
    public function getAcademicYear(): ?AcademicYear
    {
        return $this->AcademicYear;
    }

    /**
     * @param AcademicYear|null $AcademicYear
     * @return Activity
     */
    public function setAcademicYear(?AcademicYear $AcademicYear): Activity
    {
        $this->AcademicYear = $AcademicYear;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getActive(): ?string
    {
        return $this->active;
    }

    /**
     * @param string|null $active
     * @return Activity
     */
    public function setActive(?string $active): Activity
    {
        $this->active = in_array($active, self::getBooleanList()) ? $active : 'Y';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRegistration(): ?string
    {
        return $this->registration;
    }

    /**
     * @param string|null $registration
     * @return Activity
     */
    public function setRegistration(?string $registration): Activity
    {
        $this->registration = in_array($registration, self::getBooleanList()) ? $registration : 'Y';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Activity
     */
    public function setName(?string $name): Activity
    {
        $this->name = mb_substr($name, 0, 40);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getProvider(): ?string
    {
        return $this->provider;
    }

    /**
     * @param string|null $provider
     * @return Activity
     */
    public function setProvider(?string $provider): Activity
    {
        $this->provider = in_array($provider, self::getProviderList()) ? $provider : 'School';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return Activity
     */
    public function setType(?string $type): Activity
    {
        $this->type = $type;
        return $this;
    }

    public static function getTypeList(): array
    {
        return ProviderFactory::create(Setting::class)->getSettingByScopeAsArray('Activities', 'activityTypes');
    }

    /**
     * setListingStart
     * @param \DateTime|null $listingStart
     * @return Activity
     */
    public function setListingStart(?\DateTime $listingStart): Activity
    {
        $this->listingStart = $listingStart;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getListingEnd(): ?\DateTime
    {
        return $this->listingEnd;
    }

    /**
     * @param \DateTime|null $listingEnd
     */
    public function setListingEnd(?\DateTime $listingEnd): Activity
    {
        $this->listingEnd = $listingEnd;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getProgramStart(): ?\DateTime
    {
        return $this->programStart;
    }

    /**
     * @param \DateTime|null $programStart
     */
    public function setProgramStart(?\DateTime $programStart): Activity
    {
        $this->programStart = $programStart;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getProgramEnd(): ?\DateTime
    {
        return $this->programEnd;
    }

    /**
     * @param \DateTime|null $programEnd
     */
    public function setProgramEnd(?\DateTime $programEnd): Activity
    {
        $this->programEnd = $programEnd;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getYearGroupList(): ?array
    {
        return $this->yearGroupList;
    }

    /**
     * YearGroupList.
     *
     * @param array|null $yearGroupList
     * @return Activity
     */
    public function setYearGroupList(?array $yearGroupList): Activity
    {
        $this->yearGroupList = $yearGroupList;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxParticipants(): int
    {
        return $this->maxParticipants;
    }

    /**
     * setMaxParticipants
     * @param int|null $maxParticipants
     * @return Activity
     */
    public function setMaxParticipants(?int $maxParticipants): Activity
    {
        $this->maxParticipants = intval($maxParticipants);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Activity
     */
    public function setDescription(?string $description): Activity
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getPayment(): ?float
    {
        return $this->payment ? number_format($this->payment, 2) : null;
    }

    /**
     * @param float|null $payment
     * @return Activity
     */
    public function setPayment(?float $payment): Activity
    {
        $this->payment = $payment ? number_format($payment, 2) : null;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentType(): string
    {
        return $this->paymentType;
    }

    /**
     * @param string $paymentType
     * @return Activity
     */
    public function setPaymentType(string $paymentType): Activity
    {
        $this->paymentType = in_array($paymentType, self::getPaymentTypeList()) ? $paymentType : 'Entire Programme';
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentFirmness(): string
    {
        return $this->paymentFirmness;
    }

    /**
     * @param string $paymentFirmness
     * @return Activity
     */
    public function setPaymentFirmness(string $paymentFirmness): Activity
    {
        $this->paymentFirmness = in_array($paymentFirmness, self::getPaymentFirmnessList()) ? $paymentFirmness : 'Finalised';
        return $this;
    }

    /**
     * @return array
     */
    public function getAcademicYearTermList(): array
    {
        return $this->academicYearTermList ?: [];
    }

    /**
     * @return \DateTime|null
     */
    public function getListingStart(): ?\DateTime
    {
        return $this->listingStart;
    }

    /**
     * AcademicYearTermList.
     *
     * @param array|null $academicYearTermList
     * @return Activity
     */
    public function setAcademicYearTermList(?array $academicYearTermList): Activity
    {
        $this->academicYearTermList = $academicYearTermList ?: [];
        return $this;
    }

    /**
     * getStaff
     * @return Collection|null
     */
    public function getStaff(): ?Collection
    {
        if (empty($this->staff))
            $this->staff = new ArrayCollection();
        
        if ($this->staff instanceof PersistentCollection)
            $this->staff->initialize();
        
        return $this->staff;
    }

    /**
     * @param Collection|null $staff
     * @return Activity
     */
    public function setStaff(?Collection $staff): Activity
    {
        $this->staff = $staff;
        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getStudents(): ?Collection
    {
        if (empty($this->students))
            $this->students = new ArrayCollection();

        if ($this->students instanceof PersistentCollection)
            $this->students->initialize();

        return $this->students;
    }

    /**
     * @param Collection|null $students
     * @return Activity
     */
    public function setStudents(?Collection $students): Activity
    {
        $this->students = $students;
        return $this;
    }

    /**
     * toArray
     * @param string|null $name
     * @return array
     */
    public function toArray(?string $name = null): array
    {
        return [];
    }
}