<?php
declare(strict_types=1);

namespace App\Entity\Entity\CarExternalParameters\ForCarExternalParameters;

use App\Entity\ForEntity\EntityFeature\Context\AbstractStringNotNullContext;

final class BodyForm extends AbstractStringNotNullContext
{
    public const FORM_SEDAN = 'sedan';

    public const FORM_COUPE = 'coupe';

    public const FORM_CABRIOLET = 'cabriolet';
}