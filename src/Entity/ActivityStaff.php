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

use Doctrine\ORM\Mapping as ORM;
use Kookaburra\UserAdmin\Entity\Person;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ActivityStaff
 * @package Kookaburra\Activities\Entity
 * @ORM\Entity(repositoryClass="Kookaburra\Activities\Repository\ActivityStaffRepository")
 * @ORM\Table(options={"auto_increment": 1}, name="ActivityStaff",
 *     indexes={
 *          @ORM\Index(name="activity", columns={"activity"}),
 *          @ORM\Index(name="person", columns={"person"})
 *     })
 */
class ActivityStaff
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", columnDefinition="INT(8) UNSIGNED AUTO_INCREMENT")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Activity|null
     * @ORM\ManyToOne(targetEntity="Activity", inversedBy="staff")
     * @ORM\JoinColumn(name="activity",referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    private $activity;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Kookaburra\UserAdmin\Entity\Person")
     * @ORM\JoinColumn(name="person",referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    private $person;

    /**
     * @var string
     * @ORM\Column(length=9, options={"default": "Organiser"})
     * @Assert\Choice(callback="getRoleList")
     */
    private $role = 'Organiser';

    /**
     * @var array
     */
    private static $roleList = ['Organiser', 'Coach', 'Assistant', 'Other'];

    /**
     * @return array
     */
    public static function getRoleList(): array
    {
        return self::$roleList;
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
     * @return ActivityStaff
     */
    public function setId(?int $id): ActivityStaff
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
     * @return ActivityStaff
     */
    public function setActivity(?Activity $activity): ActivityStaff
    {
        $this->activity = $activity;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getPerson(): ?Person
    {
        return $this->person;
    }

    /**
     * @param Person|null $person
     * @return ActivityStaff
     */
    public function setPerson(?Person $person): ActivityStaff
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return ActivityStaff
     */
    public function setRole(string $role): ActivityStaff
    {
        $this->role = in_array($role, self::getRoleList()) ? $role : 'Organiser';
        return $this;
    }
}