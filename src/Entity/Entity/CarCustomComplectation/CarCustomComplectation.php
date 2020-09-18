<?php
declare(strict_types=1);

namespace App\Entity\Entity\CarCustomComplectation;

use App\Entity\Entity\Car\Car;
use App\Entity\Entity\CarCustomComplectation\ForCarCustomComplectation\Id;
use App\Entity\ForEntity\AbstractEntity\AbstractCarComplectation\AbstractCarComplectation;
use App\Entity\ForEntity\AbstractEntity\AbstractCarComplectation\ForAbstractCarComplectation\AirConditioner;
use App\Entity\ForEntity\AbstractEntity\AbstractCarComplectation\ForAbstractCarComplectation\RainSensor;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarCustomComplectationRepository", readOnly=false)
 * @ORM\Table(name="car_custom_complectations")
 * @ORM\ChangeTrackingPolicy(value="DEFERRED_IMPLICIT")
 */
class CarCustomComplectation extends AbstractCarComplectation
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="CarCustomComplectationIdType", nullable=false)
     */
    private Id $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Entity\Car\Car", mappedBy="carCustomComplectation",
     *     fetch="LAZY", cascade={"persist"}, orphanRemoval=true
     * )
     */
    private Car $car;

    public function __construct(Car $car, Id $id, AirConditioner $airConditioner, RainSensor $rainSensor)
    {
        $this->car = $car;
        $this->id = $id;

        parent::__construct($airConditioner, $rainSensor);
    }

    public function setCar(Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function getCar(): Car
    {
        return $this->car;
    }
}