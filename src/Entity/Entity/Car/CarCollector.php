<?php
declare(strict_types=1);

namespace App\Entity\Entity\Car;

use App\Entity\ForEntity\AbstractCollector;

final class CarCollector extends AbstractCollector
{
    public static function createFulledCollector(Car ...$cars): self
    {
        return new self($cars);
    }
}