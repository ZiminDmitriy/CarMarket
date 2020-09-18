<?php
declare(strict_types=1);

namespace App\Service\Entity\Entity\Car;

use App\Entity\Entity\Car\CarCollector;
use App\Repository\CarRepository;
use App\Util\Common\AbstractCommonQueryFiltersCollector;

final class GetterService
{
    private CarRepository $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function getLastForDeliveryDate(AbstractCommonQueryFiltersCollector $queryFilterCollector): CarCollector
    {
        return $this->carRepository->getLastForDeliveryDate($queryFilterCollector);
    }

    public function getByFilters(AbstractCommonQueryFiltersCollector $queryFilterCollector): CarCollector
    {
        return $this->carRepository->getByFilters($queryFilterCollector);
    }
}