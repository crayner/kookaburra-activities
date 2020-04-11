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

use App\Entity\FinanceInvoice;
use App\Manager\EntityInterface;
use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;
use Kookaburra\UserAdmin\Entity\Person;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ActivityStudentRepository
 * @package Kookaburra\Activities\Entity
 * @ORM\Entity(repositoryClass="Kookaburra\Activities\Repository\ActivityStudentRepository")
 * @ORM\Table(
 *     options={"auto_increment": 1},
 *     name="ActivityStudent",
 *     indexes={
 *         @ORM\Index(name="activity", columns={"activity"}),
 *         @ORM\Index(name="person", columns={"person"}),
 *         @ORM\Index(name="invoice", columns={"invoice"}),
 *         @ORM\Index(name="backupActivity", columns={"activity_backup"})
 *     },
 *     uniqueConstraints={@ORM\UniqueConstraint(name="activityPerson", columns={"person","activity"})}
 * )
 * @UniqueEntity({"person","activity"})
 * @ORM\HasLifecycleCallbacks()
 */
class ActivityStudent implements EntityInterface
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", columnDefinition="INT(10) UNSIGNED AUTO_INCREMENT")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Activity|null
     * @ORM\ManyToOne(targetEntity="Activity", inversedBy="students")
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
     * @ORM\Column(length=12, options={"default": "Pending"})
     * @Assert\Choice(callback="getStatusList")
     */
    private $status = 'Pending';

    /**
     * @var array
     */
    private static $statusList = ['Accepted','Pending','Waiting List','Not Accepted'];

    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(type="datetime_immutable")
     */
    private $timestamp;

    /**
     * @var Activity|null
     * @ORM\ManyToOne(targetEntity="Activity")
     * @ORM\JoinColumn(name="activity_backup", referencedColumnName="id")
     */
    private $activityBackup;

    /**
     * @var string
     * @ORM\Column(length=1, name="invoice_generated", options={"default": "N"})
     */
    private $invoiceGenerated = 'N';

    /**
     * @var FinanceInvoice|null
     * @ORM\ManyToOne(targetEntity="App\Entity\FinanceInvoice")
     * @ORM\JoinColumn(name="invoice",referencedColumnName="gibbonFinanceInvoiceID")
     */
    private $invoice;

    /**
     * @return array
     */
    public static function getStatusList(): array
    {
        return self::$statusList;
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
     * @return ActivityStudent
     */
    public function setId(?int $id): ActivityStudent
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
     * @return ActivityStudent
     */
    public function setActivity(?Activity $activity): ActivityStudent
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
     * @return ActivityStudent
     */
    public function setPerson(?Person $person): ActivityStudent
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return ActivityStudent
     */
    public function setStatus(string $status): ActivityStudent
    {
        $this->status = in_array($status, self::getStatusList()) ? $status : 'Pending';
        return $this;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getTimestamp(): ?\DateTimeImmutable
    {
        return $this->timestamp;
    }

    /**
     * setTimestamp
     * @param \DateTimeImmutable|null $timestamp
     * @return ActivityStudent
     * @throws \Exception
     * @ORM\PrePersist()
     */
    public function setTimestamp(?\DateTimeImmutable $timestamp = null): ActivityStudent
    {
        $this->timestamp = $timestamp ?: new \DateTimeImmutable();
        return $this;
    }

    /**
     * @return Activity|null
     */
    public function getActivityBackup(): ?Activity
    {
        return $this->activityBackup;
    }

    /**
     * @param Activity|null $activityBackup
     * @return ActivityStudent
     */
    public function setActivityBackup(?Activity $activityBackup): ActivityStudent
    {
        $this->activityBackup = $activityBackup;
        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceGenerated(): string
    {
        return $this->invoiceGenerated;
    }

    /**
     * @param string $invoiceGenerated
     * @return ActivityStudent
     */
    public function setInvoiceGenerated(string $invoiceGenerated): ActivityStudent
    {
        $this->invoiceGenerated = $this->checkBoolean($invoiceGenerated, 'N');
        return $this;
    }

    /**
     * @return FinanceInvoice|null
     */
    public function getInvoice(): ?FinanceInvoice
    {
        return $this->invoice;
    }

    /**
     * @param FinanceInvoice|null $invoice
     * @return ActivityStudent
     */
    public function setInvoice(?FinanceInvoice $invoice): ActivityStudent
    {
        $this->invoice = $invoice;
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