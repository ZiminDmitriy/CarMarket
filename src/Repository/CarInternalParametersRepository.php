<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Entity\CarInternalParameters\CarInternalParameters;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class CarInternalParametersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarInternalParameters::class);
    }
}