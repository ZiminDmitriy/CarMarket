<?php
declare(strict_types=1);

namespace App\Entity\Entity\CarFactoryComplectation;

use App\Entity\Entity\Car\Car;
use App\Entity\Entity\CarBrand\CarBrand;
use App\Entity\Entity\CarFactoryComplectation\ForCarFactoryComplectation\Id;
use App\Entity\ForEntity\AbstractEntity\AbstractCarComplectation\AbstractCarComplectation;
use App\Entity\ForEntity\AbstractEntity\AbstractCarComplectation\ForAbstractCarComplectation\AirConditioner;
use App\Entity\ForEntity\AbstractEntity\AbstractCarComplectation\ForAbstractCarComplectation\RainSensor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarFactoryComplectationRepository", readOnly=false)
 * @ORM\Table(name="car_factory_complectations")
 * @ORM\ChangeTrackingPolicy(value="DEFERRED_IMPLICIT")
 */
class CarFactoryComplectation extends AbstractCarComplectation
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="CarFactoryComplectationIdType", nullable=false)
     */
    private Id $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entity\CarBrand\CarBrand",
     *     inversedBy="carFactoryComplectations", cascade={"persist"}, fetch="LAZY"
     * )
     * @ORM\JoinColumn(name="car_factory_complectation_id", referencedColumnName="id",
     *      nullable=false, onDelete="CASCADE"
     * )
     */
    private CarBrand $carBrand;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Entity\Car\Car", mappedBy="carFactoryComplectation",
     *     cascade={"persist"}, fetch="LAZY", orphanRemoval=false
     * )
     */
    private Collection $cars;

    public function __construct(CarBrand $carBrand, Id $id, AirConditioner $airConditioner, RainSensor $rainSensor)
    {
        $this->carBrand = $carBrand;
        $this->id = $id;
        $this->cars = new ArrayCollection();

        parent::__construct($airConditioner, $rainSensor);
    }

    public function setCarBrand(CarBrand $carBrand): self
    {
        $this->carBrand = $carBrand;

        return $this;
    }

    public function addCar(Car $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars->add($car);
        }


        return $this;
    }

    public function getCarBrand(): CarBrand
    {
        return $this->carBrand;
    }

    public function getCars(): Collection
    {
        return $this->cars;
    }
}
