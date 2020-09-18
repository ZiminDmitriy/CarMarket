<?php
declare(strict_types=1);

namespace App\Util\Common;

abstract class AbstractCommonQueryFiltersCollector extends AbstractDTO
{
    private int $limit = 12;

    private int $offset = 0;

    final public function setLimit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    final public function setOffset(int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

    final public function getLimit(): int
    {
        return $this->limit;
    }

    final public function getOffset(): int
    {
        return $this->offset;
    }

    abstract protected function refreshCustomFilters(): void;

    private function refreshCommonFilters(): void
    {
        $this->limit = 12;
        $this->offset = 0;
    }

    final public function refreshFilters(): self
    {
        $this->refreshCommonFilters();
        $this->refreshCustomFilters();

        return $this;
    }
}