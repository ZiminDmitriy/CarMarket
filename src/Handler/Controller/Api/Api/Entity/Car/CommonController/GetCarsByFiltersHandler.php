<?php
declare(strict_types=1);

namespace App\Handler\Controller\Api\Api\Entity\Car\CommonController;

use App\Entity\Entity\CarBrand\ForCarBrand\Name;
use App\Handler\Controller\Api\Api\Entity\Car\CommonController\ForGetCarsByFiltersHandler\QueryFiltersCollector;
use App\Service\Entity\Entity\Car\GetterService as CarGetterService;
use App\Util\Entity\Entity\Car\CommonCarsInformationPreparer;

class GetCarsByFiltersHandler
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

    public function getCarsByFilters(QueryFiltersCollector $queryFiltersCollector): array
    {
        if (!is_null($brandName = $queryFiltersCollector->getBrandName())
            && !in_array($brandName, Name::EXISTING_NAMES, true)) {
            return [];
        }

        $carCollector = $this->carGetterService->getByFilters($queryFiltersCollector);

        $carsInformationRegistry = $this->commonCarInformationPreparer->createCarInformationRegistry($carCollector);

        return $carsInformationRegistry;
    }
}