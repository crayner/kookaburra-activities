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

use Kookaburra\Activities\Entity\ActivityStudent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class ActivityStudentRepository
 * @package Kookaburra\Activities\Repository
 */
class ActivityStudentRepository extends ServiceEntityRepository
{
    /**
     * ActivityStudentRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActivityStudent::class);
    }
}
