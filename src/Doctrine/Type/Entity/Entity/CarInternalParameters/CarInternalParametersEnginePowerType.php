<?php
declare(strict_types=1);

namespace App\Doctrine\Type\Entity\Entity\CarInternalParameters;

use App\Doctrine\Type\Entity\ForEntity\EntityFeature\Context\AbstractFloatNotNullContextType;
use App\Entity\Entity\CarInternalParameters\ForCarInternalParameters\EnginePower;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use InvalidArgumentException;

final class CarInternalParametersEnginePowerType extends AbstractFloatNotNullContextType
{
    public function convertToPHPValue($value, AbstractPlatform $platform): EnginePower
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException(
                sprintf('$value in %s must be of type String', get_called_class()), 0, null
            );
        }

        return new EnginePower((float)$value);
    }
}