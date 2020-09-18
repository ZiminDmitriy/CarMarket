<?php
declare(strict_types=1);

namespace App\Util\Entity\Entity\Car;

use App\Entity\Entity\Car\Car;
use App\Entity\Entity\Car\CarCollector;
use App\Entity\ForEntity\AbstractEntity\AbstractCarComplectation\AbstractCarComplectation;
use App\Entity\ForEntity\EntityFeature\AbstractFeature\AbstractDateTime;

final class CommonCarsInformationPreparer
{
    public function createCarInformationRegistry(CarCollector $carCollector): array
    {
        $carsInformationRegistry = [];

        if (!$carCollector->isEmpty()) {
            /** @var Car $car */
            foreach ($carCollector as $key => $car) {
                $carsInformationRegistry[$key]['specialNumber'] = $car->getSpecialNumber()->getValue();

                $brand = $car->getCarBrand() ?? null;
                if (!is_null($brand)) {
                    $carsInformationRegistry[$key]['brandName'] = $brand->getName()->getValue();
                    $carsInformationRegistry[$key]['model'] = $brand->getModel()->getValue();


                }

                // Get only custom complectation if it exists
                /** @var AbstractCarComplectation $carComplectation */
                if (!is_null($carComplectation = $car->getCarCustomComplectation())
                    || !is_null($carComplectation = $car->getCarFactoryComplectation())) {
                    $carsInformationRegistry[$key]['complectation'] = [
                        'airConditioner' => $carComplectation->getAirConditioner()->getValue(),
                        'rainSensor' => $carComplectation->getRainSensor()->getValue()
                    ];
                }

                $carCommonParameters = $car->getCarCommonParameters();
                if (!is_null($carCommonParameters)) {
                    $carsInformationRegistry[$key]['commonParameters'] = [
                        'usageCondition' => $carCommonParameters->getUsageCondition()->getValue(),
                        'price' => $carCommonParameters->getPrice()->getValue(),
                        'mileage' => $carCommonParameters->getMileage()->getValue(),
                        'releaseDate' => $carCommonParameters->getReleaseDate()->getValue(),
                        'deliveryDate' => $carCommonParameters->getDeliveryDate()->getValue()
                    ];
                }

                $carExternalParameters = $car->getCarExternalParameters();
                if (!is_null($carExternalParameters)) {
                    $carsInformationRegistry[$key]['externalParameters'] = [
                        'bodyForm' => $carExternalParameters->getBodyForm()->getValue(),
                        'color' => $carExternalParameters->getColor()->getValue()
                    ];
                }

                $carInternalParameters = $car->getCarInternalParameters();
                if (!is_null($carInternalParameters)) {
                    $carsInformationRegistry[$key]['internalParameters'] = [
                        'enginePower' => $carInternalParameters->getEnginePower()->getValue(),
                        'torque' => $carInternalParameters->getTorque()->getValue()
                    ];
                }
            }
        }

        return $carsInformationRegistry;
    }
}