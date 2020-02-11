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

use App\Manager\EntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Kookaburra\SchoolAdmin\Entity\DaysOfWeek;
use Kookaburra\SchoolAdmin\Entity\Facility;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ActivitySlot
 * @package Kookaburra\Activities\Entity
 * @ORM\Entity(repositoryClass="Kookaburra\Activities\Repository\ActivitySlotRepository")
 * @ORM\Table(options={"auto_increment": 1}, name="ActivitySlot",
 *     indexes={
 *     @ORM\Index(name="facility", columns={"facility"}),
 *     @ORM\Index(name="activity", columns={"activity"}),
 *     @ORM\Index(name="dayOfWeek", columns={"day_of_week"})}
 * )
 */
class ActivitySlot implements EntityInterface
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", columnDefinition="INT(10) UNSIGNED AUTO_INCREMENT")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Activity|null
     * @ORM\ManyToOne(targetEntity="Activity", inversedBy="slots")
     * @ORM\JoinColumn(name="activity",referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    private $activity;

    /**
     * @var Facility|null
     * @ORM\ManyToOne(targetEntity="Kookaburra\SchoolAdmin\Entity\Facility")
     * @ORM\JoinColumn(name="facility",referencedColumnName="id",nullable=true)
     */
    private $facility;

    /**
     * @var string|null
     * @ORM\Column(length=50, name="location_external")
     * @Assert\Length(max=50)
     */
    private $locationExternal;

    /**
     * @var DaysOfWeek|null
     * @ORM\ManyToOne(targetEntity="Kookaburra\SchoolAdmin\Entity\DaysOfWeek")
     * @ORM\JoinColumn(name="day_of_week",referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    private $dayOfWeek;

    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(type="time_immutable",name="time_start")
     */
    private $timeStart;

    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(type="time",name="time_end")
     */
    private $timeEnd;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return ActivitySlot
     */
    public function setId(?int $id): ActivitySlot
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Activity|null
     */
    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    /**
     * @param Activity|null $activity
     * @return ActivitySlot
     */
    public function setActivity(?Activity $activity): ActivitySlot
    {
        $this->activity = $activity;
        return $this;
    }

    /**
     * @return Facility|null
     */
    public function getFacility(): ?Facility
    {
        return $this->facility;
    }

    /**
     * Facility.
     *
     * @param Facility|null $facility
     * @return ActivitySlot
     */
    public function setFacility(?Facility $facility): ActivitySlot
    {
        $this->facility = $facility;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLocationExternal(): ?string
    {
        return $this->locationExternal;
    }

    /**
     * @param string|null $locationExternal
     * @return ActivitySlot
     */
    public function setLocationExternal(?string $locationExternal): ActivitySlot
    {
        $this->locationExternal = mb_substr($locationExternal,0,50);
        return $this;
    }

    /**
     * @return DaysOfWeek|null
     */
    public function getDayOfWeek(): ?DaysOfWeek
    {
        return $this->dayOfWeek;
    }

    /**
     * @param DaysOfWeek|null $dayOfWeek
     * @return ActivitySlot
     */
    public function setDayOfWeek(?DaysOfWeek $dayOfWeek): ActivitySlot
    {
        $this->dayOfWeek = $dayOfWeek;
        return $this;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getTimeStart(): ?\DateTimeImmutable
    {
        return $this->timeStart;
    }

    /**
     * TimeStart.
     *
     * @param \DateTimeImmutable|null $timeStart
     * @return ActivitySlot
     */
    public function setTimeStart(?\DateTimeImmutable $timeStart): ActivitySlot
    {
        $this->timeStart = $timeStart;
        return $this;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getTimeEnd(): ?\DateTimeImmutable
    {
        return $this->timeEnd;
    }

    /**
     * TimeEnd.
     *
     * @param \DateTimeImmutable|null $timeEnd
     * @return ActivitySlot
     */
    public function setTimeEnd(?\DateTimeImmutable $timeEnd): ActivitySlot
    {
        $this->timeEnd = $timeEnd;
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