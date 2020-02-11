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
use Kookaburra\UserAdmin\Entity\Person;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ActivityAttendance
 * @package Kookaburra\Activities\Entity
 * @ORM\Entity(repositoryClass="Kookaburra\Activities\Repository\ActivityAttendanceRepository")
 * @ORM\Table(
 *     options={"auto_increment": 1},
 *     name="ActivityAttendance",
 *     indexes={
 *          @ORM\Index(name="activity", columns={"activity"}),
 *          @ORM\Index(name="personTaker", columns={"person_taker"})}
 * )
 * @ORM\HasLifecycleCallbacks
 */
class ActivityAttendance implements EntityInterface
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", columnDefinition="INT(10) UNSIGNED AUTO_INCREMENT")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return ActivityAttendance
     */
    public function setId(?int $id): ActivityAttendance
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @var Activity|null
     * @ORM\ManyToOne(targetEntity="Activity")
     * @ORM\JoinColumn(name="activity", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    private $activity;

    /**
     * @return Activity|null
     */
    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    /**
     * @param Activity|null $activity
     * @return ActivityAttendance
     */
    public function setActivity(?Activity $activity): ActivityAttendance
    {
        $this->activity = $activity;
        return $this;
    }

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Kookaburra\UserAdmin\Entity\Person")
     * @ORM\JoinColumn(name="person_taker", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    private $personTaker;

    /**
     * @return Person|null
     */
    public function getPersonTaker(): ?Person
    {
        return $this->personTaker;
    }

    /**
     * @param Person|null $personTaker
     * @return ActivityAttendance
     */
    public function setPersonTaker(?Person $personTaker): ActivityAttendance
    {
        $this->personTaker = $personTaker;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $attendance;

    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $date;

    /**
     * @return string|null
     */
    public function getAttendance(): ?string
    {
        return $this->attendance;
    }

    /**
     * @param string|null $attendance
     * @return ActivityAttendance
     */
    public function setAttendance(?string $attendance): ActivityAttendance
    {
        $this->attendance = $attendance;
        return $this;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @param \DateTimeImmutable|null $date
     * @return ActivityAttendance
     */
    public function setDate(?\DateTimeImmutable $date): ActivityAttendance
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(type="datetime", name="timestampTaken", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $timestampTaken;

    /**
     * @return \DateTimeImmutable|null
     */
    public function getTimestampTaken(): ?\DateTimeImmutable
    {
        return $this->timestampTaken;
    }

    /**
     * setTimestampTaken
     * @param \DateTimeImmutable|null $timestampTaken
     * @return ActivityAttendance
     * @throws \Exception
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function setTimestampTaken(?\DateTimeImmutable $timestampTaken = null): ActivityAttendance
    {
        $this->timestampTaken = $timestampTaken ?: new \DateTimeImmutable();
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