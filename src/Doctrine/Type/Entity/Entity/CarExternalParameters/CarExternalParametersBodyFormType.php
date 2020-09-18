<?php
declare(strict_types=1);

namespace App\Doctrine\Type\Entity\Entity\CarExternalParameters;

use App\Doctrine\Type\Entity\ForEntity\EntityFeature\Context\AbstractStringNotNullContextType;
use App\Entity\Entity\CarExternalParameters\ForCarExternalParameters\BodyForm;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use InvalidArgumentException;

final class CarExternalParametersBodyFormType extends AbstractStringNotNullContextType
{
    public function convertToPHPValue($value, AbstractPlatform $platform): BodyForm
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException(
                sprintf('$value in %s must be of type String', get_called_class()), 0, null
            );
        }

        return new BodyForm($value);
    }
}