<?php
declare(strict_types=1);

namespace App\Controller\Api\Api\Entity\Car;

use App\Controller\Api\Api\AbstractManagerController;
use App\Handler\Controller\Api\Api\Entity\Car\CommonController\ForGetCarsByFiltersHandler\QueryFiltersCollector as GCBFHQueryFiltersCollector;
use App\Handler\Controller\Api\Api\Entity\Car\CommonController\ForGetLastCarsHandler\QueryFiltersCollector as GLCHQueryFiltersCollector;
use App\ParamConverter\Controller\Api\Api\Entity\Car\CommonController\GetCarsByFiltersParamConverter;
use App\ParamConverter\Controller\Api\Api\Entity\Car\CommonController\GetLastCarsParamConverter;
use App\Handler\Controller\Api\Api\Entity\Car\CommonController\GetCarsByFiltersHandler;
use App\Handler\Controller\Api\Api\Entity\Car\CommonController\GetLastCarsHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class CommonController extends AbstractManagerController
{
    /**
     * @Route("/api/api/car/getLastCars", methods={"GET"})
     * @ParamConverter(name="glchQueryFiltersCollector", class=GLCHQueryFiltersCollector::class,
     *     converter=GetLastCarsParamConverter::class
     * )
     */
    public function getLastCars(
        GLCHQueryFiltersCollector $glchQueryFiltersCollector, GetLastCarsHandler $getLastCarsHandler
    ): JsonResponse
    {
        $responseData = $getLastCarsHandler->getLastCars($glchQueryFiltersCollector);

        return new JsonResponse($this->safelyArrayJsonEncode($responseData, 0, 512), 200, [], true);
    }

    /**
     * @Route("/api/api/car/getCarsByFilters", methods={"GET"})
     * @ParamConverter(name="gcbfhQueryFiltersCollector", class=GCBFHQueryFiltersCollector::class,
     *     converter=GetCarsByFiltersParamConverter::class
     * )
     */
    public function getCarsByFilters(
        GCBFHQueryFiltersCollector $gcbfhQueryFiltersCollector, GetCarsByFiltersHandler $getCarsByFiltersHandler
    ): JsonResponse
    {
        $responseData = $getCarsByFiltersHandler->getCarsByFilters($gcbfhQueryFiltersCollector);

        return new JsonResponse($this->safelyArrayJsonEncode($responseData, 0, 512), 200, [], true);
    }
}