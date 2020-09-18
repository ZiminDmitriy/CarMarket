<?php
declare(strict_types=1);

namespace App\Handler\Controller\Api\Api\Entity\Car\CommonController;

use App\Handler\Controller\Api\Api\Entity\Car\CommonController\ForGetLastCarsHandler\QueryFiltersCollector;
use App\Service\Entity\Entity\Car\GetterService as CarGetterService;
use App\Util\Entity\Entity\Car\CommonCarsInformationPreparer;

final class GetLastCarsHandler
{
    private CarGetterService $carGetterService;

    private CommonCarsInformationPreparer $commonCarInformationPreparer;

    public function __construct(
        CarGetterService $carGetterService,
        CommonCarsInformationPreparer $commonCarInformationPreparer
    )
    {
        $this->carGetterService = $carGetterService;
        $this->commonCarInformationPreparer = $commonCarInformationPreparer;
    }

    public function getLastCars(QueryFiltersCollector $queryFiltersCollector): array
    {
        $carCollector = $this->carGetterService->getLastForDeliveryDate($queryFiltersCollector);

        $carsInformationRegistry = $this->commonCarInformationPreparer->createCarInformationRegistry($carCollector);

        return $carsInformationRegistry;
    }
}