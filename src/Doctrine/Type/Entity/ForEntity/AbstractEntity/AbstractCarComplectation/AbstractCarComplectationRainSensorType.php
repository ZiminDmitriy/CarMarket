<?php
declare(strict_types=1);

namespace App\Doctrine\Type\Entity\ForEntity\AbstractEntity\AbstractCarComplectation;

use App\Doctrine\Type\Entity\ForEntity\EntityFeature\Context\AbstractBooleanNotNullContextType;
use App\Entity\ForEntity\AbstractEntity\AbstractCarComplectation\ForAbstractCarComplectation\RainSensor;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use InvalidArgumentException;

final class AbstractCarComplectationRainSensorType extends AbstractBooleanNotNullContextType
{
    public function convertToPHPValue($value, AbstractPlatform $platform): RainSensor
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException(
                sprintf('$value in %s must be of type String', get_called_class()), 0, null
            );
        }

        return new RainSensor((bool)$value);
    }
}