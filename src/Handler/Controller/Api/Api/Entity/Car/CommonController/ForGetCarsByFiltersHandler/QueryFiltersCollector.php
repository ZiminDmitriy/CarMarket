<?php
declare(strict_types=1);

namespace App\Handler\Controller\Api\Api\Entity\Car\CommonController\ForGetCarsByFiltersHandler;

use App\Util\Common\AbstractCommonQueryFiltersCollector;

final class QueryFiltersCollector extends AbstractCommonQueryFiltersCollector
{
    private ?string $brandName = null;

    private ?string $usageCondition = null;

    private ?int $fromPrice = null;

    private ?int $beforePrice = null;

    private ?string $fromReleaseDate = null;

    private ?string $beforeReleaseDate = null;

    private ?bool $rainSensor = null;

    protected function refreshCustomFilters(): void
    {
        $this->brandName = null;
        $this->usageCondition = null;
        $this->fromPrice = null;
        $this->beforePrice = null;
        $this->fromReleaseDate = null;
        $this->beforeReleaseDate = null;
        $this->rainSensor = null;
    }

    public function setBrandName(string $brandName): self
    {
        $this->brandName = $brandName;

        return $this;
    }

    public function setUsageCondition(string $usageCondition): self
    {
        $this->usageCondition = $usageCondition;

        return $this;
    }

    public function setFromPrice(int $fromPrice): self
    {
        $this->fromPrice = $fromPrice;

        return $this;
    }

    public function setBeforePrice(int $beforePrice): self
    {
        $this->beforePrice = $beforePrice;

        return $this;
    }

    public function setFromReleaseDate(string $fromReleaseDate): self
    {
        $this->fromReleaseDate = $fromReleaseDate;

        return $this;
    }

    public function setBeforeReleaseDate(string $beforeReleaseDate): void
    {
        $this->beforeReleaseDate = $beforeReleaseDate;
    }

    public function getFromPrice(): ?int
    {
        return $this->fromPrice;
    }

    public function getBeforePrice(): ?int
    {
        return $this->beforePrice;
    }

    public function getFromReleaseDate(): ?string
    {
        return $this->fromReleaseDate;
    }

    public function getBeforeReleaseDate(): ?string
    {
        return $this->beforeReleaseDate;
    }

    public function setRainSensor(bool $rainSensor): self
    {
        $this->rainSensor = $rainSensor;

        return $this;
    }

    public function getBrandName(): ?string
    {
        return $this->brandName;
    }

    public function getUsageCondition(): ?string
    {
        return $this->usageCondition;
    }

    public function getRainSensor(): ?bool
    {
        return $this->rainSensor;
    }
}