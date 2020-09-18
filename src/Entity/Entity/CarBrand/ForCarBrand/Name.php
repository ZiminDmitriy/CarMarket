<?php
declare(strict_types=1);

namespace App\Entity\Entity\CarBrand\ForCarBrand;

use App\Entity\ForEntity\EntityFeature\Context\AbstractStringNotNullContext;

final class Name extends AbstractStringNotNullContext
{
    public const EXISTING_NAMES = [
        self::BRAND_BMW,
        self::BRAND_MERCEDES,
        self::BRAND_AUDI,
        self::BRAND_MAZDA,
        self::BRAND_VOLKSWAGEN
    ];

    public const BRAND_BMW = 'bmv';

    public const BRAND_MERCEDES = 'mercedes';

    public const BRAND_AUDI = 'audi';

    public const BRAND_MAZDA = 'mazda';

    public const BRAND_VOLKSWAGEN = 'volkswagen';
}