<?php
declare(strict_types=1);

namespace App\Doctrine\Type\Entity\ForEntity\AbstractEntity\AbstractCarComplectation;

use App\Doctrine\Type\Entity\ForEntity\EntityFeature\Context\AbstractBooleanNotNullContextType;
use App\Entity\ForEntity\AbstractEntity\AbstractCarComplectation\ForAbstractCarComplectation\AirConditioner;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use InvalidArgumentException;

final class AbstractCarComplectationAirConditionerType extends AbstractBooleanNotNullContextType
{
    public function convertToPHPValue($value, AbstractPlatform $platform): AirConditioner
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException(
                sprintf('$value in %s must be of type String', get_called_class()), 0, null
            );
        }

        return new AirConditioner((bool)$value);
    }
}