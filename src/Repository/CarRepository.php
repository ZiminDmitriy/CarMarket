<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Entity\Car\Car;
use App\Entity\Entity\Car\CarCollector;
use App\Handler\Controller\Api\Api\Entity\Car\CommonController\ForGetCarsByFiltersHandler\QueryFiltersCollector as GCBFHQueryFiltersCollector;
use App\Util\Common\AbstractCommonQueryFiltersCollector;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\ParameterType;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;

final class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    public function getByFilters(AbstractCommonQueryFiltersCollector $queryFilterCollector): CarCollector
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder
            ->select('c')
            ->from($this->_entityName, 'c', null)
            ->setMaxResults($queryFilterCollector->getLimit())
            ->setFirstResult($queryFilterCollector->getOffset());

        if ($queryFilterCollector instanceof GCBFHQueryFiltersCollector) {
            if (!is_null($brandName = $queryFilterCollector->getBrandName())) {
                $queryBuilder
                    ->innerJoin('c.carBrand', 'cb')
                    ->andWhere('cb.name = :brandName')
                    ->setParameter('brandName', $brandName, ParameterType::STRING);
            }

            $fromPrice = $queryFilterCollector->getFromPrice();
            $beforePrice = $queryFilterCollector->getBeforePrice();
            $fromReleaseDate = $queryFilterCollector->getFromReleaseDate();
            $beforeReleaseDate = $queryFilterCollector->getBeforeReleaseDate();
            $usageCondition = $queryFilterCollector->getUsageCondition();
            if (!is_null($fromPrice) || !is_null($beforePrice)
                || !is_null($fromReleaseDate) || !is_null($beforeReleaseDate)
                || !is_null($usageCondition)) {
                $queryBuilder->innerJoin('c.carCommonParameters', 'ccp');

                $doOrderByForPrice = false;
                if (!is_null($fromPrice)) {
                    $queryBuilder
                        ->andWhere('ccp.price >= :fromPrice')
                        ->setParameter('fromPrice', $fromPrice, ParameterType::INTEGER);

                    $doOrderByForPrice = true;

                }
                if (!is_null($beforePrice)) {
                    $queryBuilder
                        ->andWhere('ccp.price <= :beforePrice')
                        ->setParameter('beforePrice', $beforePrice, ParameterType::INTEGER);

                    $doOrderByForPrice = true;

                }

                $doOrderByForReleaseDate = false;
                if (!is_null($fromReleaseDate)) {
                    $queryBuilder
                        ->andWhere('ccp.releaseDate >= :fromReleaseDate')
                        ->setParameter('fromReleaseDate', $fromReleaseDate, ParameterType::STRING);

                    $doOrderByForReleaseDate = true;
                }
                if (!is_null($beforeReleaseDate)) {
                    $queryBuilder
                        ->andWhere('ccp.releaseDate <= :beforeReleaseDate')
                        ->setParameter('beforeReleaseDate', $beforeReleaseDate, ParameterType::STRING);

                    $doOrderByForReleaseDate = true;
                }

                if (!is_null($usageCondition)) {
                    $queryBuilder
                        ->andWhere('ccp.usageCondition = :usageCondition')
                        ->setParameter('usageCondition', $usageCondition, ParameterType::STRING);
                }

                $doOrderByForPrice ? $queryBuilder->addOrderBy('ccp.price', 'ASC') : null;
                $doOrderByForReleaseDate ? $queryBuilder->addOrderBy('ccp.releaseDate', 'ASC') : null;
            }

            if (!is_null($rainSensor = $queryFilterCollector->getRainSensor())) {
                $queryBuilder
                    ->leftJoin('c.carCustomComplectation', 'ccc')
                    ->leftJoin('c.carFactoryComplectation', 'cfc')
                    ->andWhere(
                        '(
                            (c.carCustomComplectation IS NOT NULL AND ccc.rainSensor = :rainSensor) 
                            OR (c.carCustomComplectation IS NULL AND cfc.rainSensor = :rainSensor)
                        )'
                    )
                    ->setParameter('rainSensor', $queryFilterCollector->getRainSensor(), ParameterType::BOOLEAN);
            }
        }

        $carsRegistry = $queryBuilder->getQuery()->getResult(AbstractQuery::HYDRATE_OBJECT);

        return
            !empty($carsRegistry) ?
                CarCollector::createFulledCollector(...$carsRegistry) :
                CarCollector::createEmptyCollector();

    }

    public function getLastForDeliveryDate(AbstractCommonQueryFiltersCollector $queryFilterCollector): CarCollector
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder
            ->select('c')
            ->from($this->_entityName, 'c', null)
            ->innerJoin('c.carCommonParameters', 'ccp')
            ->orderBy('ccp.releaseDate', 'DESC')
            ->setMaxResults($queryFilterCollector->getLimit());

        $carsRegistry = $queryBuilder->getQuery()->getResult(AbstractQuery::HYDRATE_OBJECT);

        return
            !empty($carsRegistry) ?
                CarCollector::createFulledCollector(...$carsRegistry) :
                CarCollector::createEmptyCollector();
    }
}