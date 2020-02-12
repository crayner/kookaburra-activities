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
namespace Kookaburra\Activities\Repository;

use Kookaburra\Activities\Entity\Activity;
use Kookaburra\UserAdmin\Entity\Person;
use Kookaburra\SchoolAdmin\Util\AcademicYearHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class ActivityRepository
 * @package Kookaburra\Activities\Repository
 */
class ActivityRepository extends ServiceEntityRepository
{
    /**
     * ActivityRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activity::class);
    }

    /**
     * findByStaff
     * @param Person $person
     * @return array
     */
    public function findByStaff(Person $person): array
    {
        return $this->createQueryBuilder('a')
            ->select('DISTINCT a')
            ->leftJoin('a.staff', 'a_s')
            ->where('a_s.person = :person')
            ->setParameter('person', $person)
            ->andWhere('a.academicYear = :academicYear')
            ->setParameter('academicYear', AcademicYearHelper::getCurrentAcademicYear())
            ->getQuery()
            ->getResult();
    }

    /**
     * findByStudent
     * @param Person $person
     * @return array
     */
    public function findByStudent(Person $person): array
    {
        return $this->createQueryBuilder('a')
            ->select('DISTINCT a')
            ->leftJoin('a.students', 'a_s')
            ->where('a_s.person = :person')
            ->setParameter('person', $person)
            ->andWhere('a.academicYear = :academicYear')
            ->setParameter('academicYear', AcademicYearHelper::getCurrentAcademicYear())
            ->getQuery()
            ->getResult();
    }

    /**
     * findForPagination
     * @return array
     */
    public function findForPagination(): array
    {
        return $this->createQueryBuilder('a')
            ->select(['a','s', 'd'])
            ->leftJoin('a.slots', 's')
            ->leftJoin('s.dayOfWeek', 'd')
            ->orderBy('a.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
