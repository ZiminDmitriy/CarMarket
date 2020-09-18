<?php
declare(strict_types=1);

namespace App\Entity\ForEntity\AbstractEntity\AbstractCarComplectation;

use App\Entity\ForEntity\AbstractEntity\AbstractCarComplectation\ForAbstractCarComplectation\AirConditioner;
use App\Entity\ForEntity\AbstractEntity\AbstractCarComplectation\ForAbstractCarComplectation\RainSensor;
use Doctrine\ORM\Mapping as ORM;

abstract class AbstractCarComplectation
{
    /**
     * @ORM\Column(name="air_conditioner", type="AbstractCarComplectationAirConditionerType", nullable=false)
     */
    protected AirConditioner $airConditioner;

    /**
     * @ORM\Column(name="rain_sensor", type="AbstractCarComplectationRainSensorType", nullable=false)
     */
    protected RainSensor $rainSensor;

    public function __construct(AirConditioner $airConditioner, RainSensor $rainSensor)
    {
        $this->rainSensor = $rainSensor;
        $this->airConditioner = $airConditioner;
    }

    public function setAirConditioner(AirConditioner $airConditioner): self
    {
        $this->airConditioner = $airConditioner;

        return $this;
    }

    public function setRainSensor(RainSensor $rainSensor): self
    {
        $this->rainSensor = $rainSensor;

        return $this;
    }

    public function getAirConditioner(): AirConditioner
    {
        return $this->airConditioner;
    }

    public function getRainSensor(): RainSensor
    {
        return $this->rainSensor;
    }
}