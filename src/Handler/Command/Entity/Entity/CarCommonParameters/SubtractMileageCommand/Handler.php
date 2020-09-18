<?php
declare(strict_types=1);

namespace App\Handler\Command\Entity\Entity\CarCommonParameters\SubtractMileageCommand;

use App\Entity\Entity\CarCommonParameters\CarCommonParameters;
use Doctrine\DBAL\ParameterType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Exception;

final class Handler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function subtractMileage(int $percent, int $mileageMaxBar): void
    {
        $queryBuilder = $this->getPreparedDQL($percent, $mileageMaxBar);

        $this->entityManager->beginTransaction();
        try {
            $queryBuilder->getQuery()->execute(null, null);

            $this->entityManager->commit();
        } catch (Exception $exception) {
            $this->entityManager->rollback();

            throw $exception;
        }
    }

    private function getPreparedDQL(int $percent, int $mileageMaxBar): QueryBuilder
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->update(CarCommonParameters::class, 'e')
            ->set('e.mileage', sprintf('FLOOR(%s * e.mileage)', (string)((100 - $percent) / 100)))
            ->where('e.mileage >= :mileageMaxBar')
            ->setParameter('mileageMaxBar', $mileageMaxBar, ParameterType::INTEGER);

        return $queryBuilder;
    }
}