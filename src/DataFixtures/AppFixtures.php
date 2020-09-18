<?php

namespace App\DataFixtures;

use App\Entity\Entity\Car\Car;
use App\Entity\Entity\Car\ForCar\SpecialNumber;
use App\Entity\Entity\CarBrand\CarBrand;
use App\Entity\Entity\CarBrand\ForCarBrand\Id as CarBrandId;
use App\Entity\Entity\CarBrand\ForCarBrand\Model;
use App\Entity\Entity\CarBrand\ForCarBrand\Name;
use App\Entity\Entity\CarCommonParameters\CarCommonParameters;
use App\Entity\Entity\CarCommonParameters\ForCarCommonParameters\DeliveryDate;
use App\Entity\Entity\CarCommonParameters\ForCarCommonParameters\Id as CarCommonParametersId;
use App\Entity\Entity\CarCommonParameters\ForCarCommonParameters\Mileage;
use App\Entity\Entity\CarCommonParameters\ForCarCommonParameters\Price;
use App\Entity\Entity\CarCommonParameters\ForCarCommonParameters\ReleaseDate;
use App\Entity\Entity\CarCommonParameters\ForCarCommonParameters\UsageCondition;
use App\Entity\Entity\CarCustomComplectation\CarCustomComplectation;
use App\Entity\Entity\CarCustomComplectation\ForCarCustomComplectation\Id as CarCustomComplectationId;
use App\Entity\Entity\CarExternalParameters\CarExternalParameters;
use App\Entity\Entity\CarExternalParameters\ForCarExternalParameters\BodyForm;
use App\Entity\Entity\CarExternalParameters\ForCarExternalParameters\Color;
use App\Entity\Entity\CarExternalParameters\ForCarExternalParameters\Id as CarExternalParametersId;
use App\Entity\Entity\CarFactoryComplectation\CarFactoryComplectation;
use App\Entity\Entity\CarFactoryComplectation\ForCarFactoryComplectation\Id as CarFactoryComplectationId;
use App\Entity\Entity\CarInternalParameters\CarInternalParameters;
use App\Entity\Entity\CarInternalParameters\ForCarInternalParameters\EnginePower;
use App\Entity\Entity\CarInternalParameters\ForCarInternalParameters\Id as CarInternalParametersId;
use App\Entity\Entity\CarInternalParameters\ForCarInternalParameters\Torque;
use App\Entity\ForEntity\AbstractEntity\AbstractCarComplectation\ForAbstractCarComplectation\AirConditioner;
use App\Entity\ForEntity\AbstractEntity\AbstractCarComplectation\ForAbstractCarComplectation\RainSensor;
use DateInterval;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use ReflectionClass;

final class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; ++$i) {
            $carBrand = $this->createCarBrand($i);

            $carFactoryComplectationOne = $this->createCarFactoryComplectation($carBrand);
            $carFactoryComplectationTwo = $this->createCarFactoryComplectation($carBrand);

            $carBrand->setCarFactoryComplectation($carFactoryComplectationOne);
            rand(1, 10) >= 5 ? $carBrand->setCarFactoryComplectation($carFactoryComplectationTwo) : null;

            for ($j = 1; $j <= 100; ++$j) {
                $car = $this->createCar();

                $carCommonParameters = $this->createCarCommonParameters($car);

                $carCustomComplectation = $this->createCarCustomComplectation($car);

                $carExternalParameters = $this->createCarExternalParameters($car);

                $carInternalParameters = $this->createCarInternalParameters($car);

                $car
                    ->setCarBrand($carBrand)
                    ->setCarCommonParameters($carCommonParameters)
                    ->setCarExternalParameters($carExternalParameters)
                    ->setCarInternalParameters($carInternalParameters)
                    ->setCarFactoryComplectation(
                        rand(1, 10) >= 5 ? $carFactoryComplectationOne : $carFactoryComplectationTwo
                    );
                rand(1, 10) >= 7 ? $car->setCarCustomComplectation($carCustomComplectation) : null;


                $manager->persist($car);
                $manager->persist($carBrand);
            }

            $manager->flush();

            $manager->clear();
            gc_collect_cycles();
        }
    }

    private function createCar(): Car
    {
        return new Car(new SpecialNumber(Uuid::uuid4()->toString()));
    }

    private function createCarBrand(int $i): CarBrand
    {
        return new CarBrand(
            CarBrandId::create(),
            new Name(Name::EXISTING_NAMES[rand(0, count(Name::EXISTING_NAMES) - 1)]),
            new Model(sprintf('model%s', $i))
        );
    }

    private function createCarCommonParameters(Car $car): CarCommonParameters
    {
        return new CarCommonParameters(
            $car,
            CarCommonParametersId::create(),
            new Mileage(rand(1, 300000)),
            new Price(rand(500000, 50000000)),
            new ReleaseDate(
                $dateTime = (new DateTimeImmutable())->sub(new DateInterval(sprintf('P%sD', $days = rand(1, 1000))))
            ),
            new DeliveryDate($dateTime->add(new DateInterval(sprintf('P%sD', rand(1, $days))))),
            rand(1,10) >= 5 ?
                UsageCondition::createNewUsageCondition() :
                UsageCondition::createSecondHandUsageCondition()
        );
    }

    private function createCarCustomComplectation(Car $car): CarCustomComplectation
    {
        return new CarCustomComplectation(
            $car,
            CarCustomComplectationId::create(),
            new AirConditioner(rand(0, 10) >= 5),
            new RainSensor(rand(0, 10) >= 5)
        );
    }

    private function createCarExternalParameters(Car $car): CarExternalParameters
    {
        $reflectionClass = new ReflectionClass(BodyForm::class);
        $constantsRegistry = $reflectionClass->getConstants();

        return new CarExternalParameters(
            $car,
            CarExternalParametersId::create(),
            new BodyForm($constantsRegistry[array_keys($constantsRegistry)[rand(0, count($constantsRegistry) - 1)]]),
            new Color(sprintf('color%s', rand(1, 100)))
        );
    }

    private function createCarFactoryComplectation(CarBrand $carBrand): CarFactoryComplectation
    {
        return new CarFactoryComplectation(
            $carBrand,
            CarFactoryComplectationId::create(),
            new AirConditioner(rand(0, 10) >= 5),
            new RainSensor(rand(0, 10) >= 5)
        );
    }

    private function createCarInternalParameters(Car $car): CarInternalParameters
    {
        return new CarInternalParameters(
            $car,
            CarInternalParametersId::create(),
            new EnginePower(
                (float)sprintf('%s.%s', rand(1000, 10000), rand(1, 100))
            ),
            new Torque(
                (float)sprintf('%s.%s', rand(1000, 10000), rand(1, 100))
            )
        );
    }
}
