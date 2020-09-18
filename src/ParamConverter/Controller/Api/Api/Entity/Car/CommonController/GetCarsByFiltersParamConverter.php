<?php
declare(strict_types=1);

namespace App\ParamConverter\Controller\Api\Api\Entity\Car\CommonController;

use App\Exception\Controller\Api\ApiException;
use App\Handler\Controller\Api\Api\Entity\Car\CommonController\ForGetCarsByFiltersHandler\QueryFiltersCollector;
use App\Util\Common\DateTimeFormatChecker;
use App\Util\Common\TypeConvertingResolver;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

final class GetCarsByFiltersParamConverter implements ParamConverterInterface
{
    private TypeConvertingResolver $typeConvertingResolver;

    private DateTimeFormatChecker $dateTimeFormatChecker;

    public function __construct()
    {
        $this->typeConvertingResolver = new TypeConvertingResolver();
        $this->dateTimeFormatChecker = new DateTimeFormatChecker();
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getClass() == QueryFiltersCollector::class;
    }

    public function apply(Request $request, ParamConverter $configuration): void
    {
        $queryFiltersCollectors = $this->checkParametersAndConfigureFiltersCollector($request, new QueryFiltersCollector());

        $request->attributes->set($configuration->getName(), $queryFiltersCollectors);
    }

    private function checkParametersAndConfigureFiltersCollector(
        Request $request, QueryFiltersCollector $queryFiltersCollector
    ): QueryFiltersCollector
    {
        $exception = new ApiException('Bad parameters', 400, null);

        if (!is_null($limit = $request->query->get('limit', null))
            && (!is_string($limit) || !$this->typeConvertingResolver->canConvertToInteger($limit) || (int)$limit <= 0)) {
            throw $exception;
        }
        !is_null($limit) ? $queryFiltersCollector->setLimit((int)$limit) : null;

        if (!is_null($offset = $request->query->get('offset', null))
            && (!is_string($offset) || !$this->typeConvertingResolver->canConvertToInteger($offset) || (int)$offset <= 0)) {
            throw $exception;
        }
        !is_null($offset) ? $queryFiltersCollector->setOffset((int)$offset) : null;

        if (!is_null($fromPrice = $request->query->get('fromPrice', null))
            && (!is_string($fromPrice) || !$this->typeConvertingResolver->canConvertToInteger($fromPrice))) {
            throw $exception;
        }
        !is_null($fromPrice) ? $queryFiltersCollector->setFromPrice((int)$fromPrice) : null;

        if (!is_null($beforePrice = $request->query->get('beforePrice', null))
            && (!is_string($beforePrice) || !$this->typeConvertingResolver->canConvertToInteger($beforePrice))) {
            throw $exception;
        }
        !is_null($beforePrice) ? $queryFiltersCollector->setBeforePrice((int)$beforePrice) : null;

        if (!is_null($rainSensor = $request->query->get('rainSensor', null))
            && (!is_string($rainSensor) || !$this->typeConvertingResolver->canConvertToBoolean($rainSensor))) {
            throw $exception;
        }
        !is_null($rainSensor) ? $queryFiltersCollector->setRainSensor((bool)$rainSensor) : null;

        if (!is_null($fromReleaseDate = $request->query->get('fromReleaseDate', null))
            && (!is_string($fromReleaseDate) || !$this->dateTimeFormatChecker->isValidFormat($fromReleaseDate))) {
            throw $exception;
        }
        !is_null($fromReleaseDate) ? $queryFiltersCollector->setFromReleaseDate($fromReleaseDate) : null;

        if (!is_null($beforeReleaseDate = $request->query->get('beforeReleaseDate', null))
            && (!is_string($beforeReleaseDate) || !$this->dateTimeFormatChecker->isValidFormat($beforeReleaseDate))) {
            throw $exception;
        }
        !is_null($beforeReleaseDate) ? $queryFiltersCollector->setBeforeReleaseDate($beforeReleaseDate) : null;

        if (!is_null($brandName = $request->query->get('brandName', null)) && !is_string($brandName)) {
            throw $exception;
        }
        !is_null($brandName) ? $queryFiltersCollector->setBrandName($brandName) : null;

        if (!is_null($usageCondition = $request->query->get('usageCondition', null)) && !is_string($usageCondition)) {
            throw $exception;
        }
        !is_null($usageCondition) ? $queryFiltersCollector->setUsageCondition($usageCondition) : null;

        return $queryFiltersCollector;
    }
}

