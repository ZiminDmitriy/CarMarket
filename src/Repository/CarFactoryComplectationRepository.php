<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Entity\CarFactoryComplectation\CarFactoryComplectation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class CarFactoryComplectationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarFactoryComplectation::class);
    }
}