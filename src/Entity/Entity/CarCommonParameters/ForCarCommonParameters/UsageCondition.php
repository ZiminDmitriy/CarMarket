<?php
declare(strict_types=1);

namespace App\Entity\Entity\CarCommonParameters\ForCarCommonParameters;

use App\Entity\ForEntity\EntityFeature\Context\AbstractStringNotNullContext;

final class UsageCondition extends AbstractStringNotNullContext
{
    private const USAGE_CONDITION_NEW = 'new';

    private const USAGE_CONDITION_SECOND_HAND = 'second-hand';

    final public static function createNewUsageCondition(): self
    {
        return new self(self::USAGE_CONDITION_NEW);
    }

    final public static function createSecondHandUsageCondition(): self
    {
        return new self(self::USAGE_CONDITION_SECOND_HAND);
    }
}