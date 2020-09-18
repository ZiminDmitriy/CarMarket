<?php
declare(strict_types=1);

namespace App\Entity\Entity\Car;

use App\Entity\Entity\Car\ForCar\SpecialNumber;
use App\Entity\Entity\CarBrand\CarBrand;
use App\Entity\Entity\CarCommonParameters\CarCommonParameters;
use App\Entity\Entity\CarCustomComplectation\CarCustomComplectation;
use App\Entity\Entity\CarExternalParameters\CarExternalParameters;
use App\Entity\Entity\CarFactoryComplectation\CarFactoryComplectation;
use App\Entity\Entity\CarInternalParameters\CarInternalParameters;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarRepository", readOnly=false)
 * @ORM\Table(name="cars")
 * @ORM\ChangeTrackingPolicy(value="DEFERRED_IMPLICIT")
 */
class Car
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="CarIdType", nullable=false)
     */
    private SpecialNumber $specialNumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entity\CarBrand\CarBrand", inversedBy="cars",
     *     cascade={"persist"}, fetch="LAZY"
     * )
     * @ORM\JoinColumn(name="car_brand_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private ?CarBrand $carBrand;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Entity\CarCustomComplectation\CarCustomComplectation",
     *     inversedBy="car", cascade={"persist"}
     * )
     * @ORM\JoinColumn(name="car_custom_complectation_id", referencedColumnName="id",
     *     nullable=true, onDelete="SET NULL",
     * )
     */
    private ?CarCustomComplectation $carCustomComplectation;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Entity\CarExternalParameters\CarExternalParameters",
     *     inversedBy="car", fetch="LAZY", cascade={"persist"}
     * )
     * @ORM\JoinColumn(name="car_external_parameters_id", referencedColumnName="id",
     *     nullable=true, onDelete="SET NULL"
     * )
     */
    private ?CarExternalParameters $carExternalParameters;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Entity\CarInternalParameters\CarInternalParameters",
     *     inversedBy="car", cascade={"persist"}, fetch="LAZY"
     * )
     * @ORM\JoinColumn(name="car_internal_parameters_id", referencedColumnName="id",
     *     nullable=true, onDelete="SET NULL")
     */
    private ?CarInternalParameters $carInternalParameters;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Entity\CarCommonParameters\CarCommonParameters",
     *     inversedBy="car", cascade={"persist"}, fetch="LAZY"
     * )
     * @ORM\JoinColumn(name="car_common_parameters_id", referencedColumnName="id",
     *     nullable=true, onDelete="SET NULL"
     * )
     */
    private ?CarCommonParameters $carCommonParameters;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entity\CarFactoryComplectation\CarFactoryComplectation",
     *     inversedBy="cars", fetch="LAZY", cascade={"persist"}
     * )
     * @ORM\JoinColumn(name="car_factory_complectation_id", referencedColumnName="id",
     *     nullable=true, onDelete="SET NULL"
     * )
     */
    private ?CarFactoryComplectation $carFactoryComplectation;

    public function __construct(SpecialNumber $specialNumber)
    {
        $this->specialNumber = $specialNumber;
        $this->carBrand = null;
        $this->carExternalParameters = null;
        $this->carInternalParameters = null;
        $this->carCommonParameters = null;
        $this->carCustomComplectation = null;
        $this->carFactoryComplectation = null;
    }

    public function setCarBrand(CarBrand $carBrand): self
    {
        $this->carBrand = $carBrand;

        return $this;
    }

    public function setCarCustomComplectation(CarCustomComplectation $carCustomComplectation): self
    {
        $this->carCustomComplectation = $carCustomComplectation;

        return $this;
    }

    public function setCarExternalParameters(CarExternalParameters $carExternalParameters): self
    {
        $this->carExternalParameters = $carExternalParameters;

        return $this;
    }

    public function setCarInternalParameters(CarInternalParameters $carInternalParameters): self
    {
        $this->carInternalParameters = $carInternalParameters;

        return $this;
    }

    public function setCarCommonParameters(CarCommonParameters $carCommonParameters): self
    {
        $this->carCommonParameters = $carCommonParameters;

        return $this;
    }

    public function setCarFactoryComplectation(CarFactoryComplectation $carFactoryComplectation): self
    {
        $this->carFactoryComplectation = $carFactoryComplectation;

        return $this;
    }

    public function getSpecialNumber(): SpecialNumber
    {
        return $this->specialNumber;
    }

    public function getCarBrand(): ?CarBrand
    {
        return $this->carBrand;
    }

    public function getCarCustomComplectation(): ?CarCustomComplectation
    {
        return $this->carCustomComplectation;
    }

    public function getCarExternalParameters(): ?CarExternalParameters
    {
        return $this->carExternalParameters;
    }

    public function getCarInternalParameters(): ?CarInternalParameters
    {
        return $this->carInternalParameters;
    }

    public function getCarCommonParameters(): ?CarCommonParameters
    {
        return $this->carCommonParameters;
    }

    public function getCarFactoryComplectation(): ?CarFactoryComplectation
    {
        return $this->carFactoryComplectation;
    }
}