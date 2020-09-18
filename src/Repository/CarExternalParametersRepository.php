<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Entity\CarExternalParameters\CarExternalParameters;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class CarExternalParametersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarExternalParameters::class);
    }
}