<?php
declare(strict_types=1);

namespace App\Entity\Entity\CarInternalParameters;

use App\Entity\Entity\Car\Car;
use App\Entity\Entity\CarInternalParameters\ForCarInternalParameters\EnginePower;
use App\Entity\Entity\CarInternalParameters\ForCarInternalParameters\Id;
use App\Entity\Entity\CarInternalParameters\ForCarInternalParameters\Torque;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarInternalParametersRepository", readOnly=false)
 * @ORM\Table(name="car_internal_parameters")
 * @ORM\ChangeTrackingPolicy(value="DEFERRED_IMPLICIT")
 */
class CarInternalParameters
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="CarInternalParametersIdType", nullable=false)
     */
    private Id $id;

    /**
     * @ORM\Column(name="engine_power", type="CarInternalParametersEnginePowerType", nullable=false)
     */
    private EnginePower $enginePower;

    /**
     * @ORM\Column(name="torque", type="CarInternalParametersTorqueType", nullable=false)
     */
    private Torque $torque;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Entity\Car\Car", mappedBy="carInternalParameters",
     *     cascade={"persist"}, fetch="LAZY", orphanRemoval=true)
     */
    private Car $car;

    public function __construct(Car $car, Id $id, EnginePower $enginePower, Torque $torque)
    {
        $this->car = $car;
        $this->id = $id;
        $this->enginePower = $enginePower;
        $this->torque = $torque;
    }

    public function setEnginePower(EnginePower $enginePower): self
    {
        $this->enginePower = $enginePower;

        return $this;
    }

    public function setTorque(Torque $torque): self
    {
        $this->torque = $torque;

        return $this;
    }

    public function setCar(Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function getEnginePower(): EnginePower
    {
        return $this->enginePower;
    }

    public function getTorque(): Torque
    {
        return $this->torque;
    }

    public function getCar(): Car
    {
        return $this->car;
    }
}