<?php
declare(strict_types=1);

namespace App\Entity\Entity\CarCommonParameters;

use App\Entity\Entity\Car\Car;
use App\Entity\Entity\CarCommonParameters\ForCarCommonParameters\DeliveryDate;
use App\Entity\Entity\CarCommonParameters\ForCarCommonParameters\Id;
use App\Entity\Entity\CarCommonParameters\ForCarCommonParameters\Mileage;
use App\Entity\Entity\CarCommonParameters\ForCarCommonParameters\Price;
use App\Entity\Entity\CarCommonParameters\ForCarCommonParameters\ReleaseDate;
use App\Entity\Entity\CarCommonParameters\ForCarCommonParameters\UsageCondition;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarCommonParametersRepository", readOnly=false)
 * @ORM\Table(name="car_common_parameters",
 *     indexes={
 *         @ORM\Index(columns={"mileage"}),
 *         @ORM\Index(columns={"price"}),
 *         @ORM\Index(columns={"release_date"})
 *     }
 * )
 * @ORM\ChangeTrackingPolicy(value="DEFERRED_IMPLICIT")
 */
class CarCommonParameters
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="CarCommonParametersIdType", nullable=false)
     */
    private Id $id;

    /**
     * @ORM\Column(name="mileage", type="CarCommonParametersMileageType", nullable=false)
     */
    private Mileage $mileage;

    /**
     * @ORM\Column(name="price", type="CarCommonParametersPriceType", nullable=false)
     */
    private Price $price;

    /**
     * @ORM\Column(name="release_date", type="CarCommonParametersReleaseDateType", nullable=false)
     */
    private ReleaseDate $releaseDate;

    /**
     * @ORM\Column(name="delivery_date", type="CarCommonParametersDeliveryDateType", nullable=false)
     */
    private DeliveryDate $deliveryDate;

    /**
     * @ORM\Column(name="usage_condition", type="CarCommonParametersUsageConditionType", nullable=false)
     */
    private UsageCondition $usageCondition;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Entity\Car\Car", mappedBy="carCommonParameters",
     *     fetch="LAZY", cascade={"persist"}, orphanRemoval=true
     * )
     */
    private Car $car;

    public function __construct(
        Car $car,
        Id $id,
        Mileage $mileage,
        Price $price,
        ReleaseDate $releaseDate,
        DeliveryDate $deliveryDate,
        UsageCondition $usageCondition
    )
    {
        $this->car = $car;
        $this->id = $id;
        $this->mileage = $mileage;
        $this->price = $price;
        $this->releaseDate = $releaseDate;
        $this->deliveryDate = $deliveryDate;
        $this->usageCondition = $usageCondition;
    }

    public function setMileage(Mileage $mileage): self
    {
        $this->mileage = $mileage;

        return $this;
    }

    public function setPrice(Price $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function setReleaseDate(ReleaseDate $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function setUsageCondition(UsageCondition $usageCondition): self
    {
        $this->usageCondition = $usageCondition;

        return $this;
    }

    public function setDeliveryDate(DeliveryDate $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    public function setCar(Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function getMileage(): Mileage
    {
        return $this->mileage;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getReleaseDate(): ReleaseDate
    {
        return $this->releaseDate;
    }

    public function getUsageCondition(): UsageCondition
    {
        return $this->usageCondition;
    }

    public function getDeliveryDate(): DeliveryDate
    {
        return $this->deliveryDate;
    }

    public function getCar(): Car
    {
        return $this->car;
    }
}