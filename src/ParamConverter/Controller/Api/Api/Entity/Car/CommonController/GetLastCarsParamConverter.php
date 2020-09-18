<?php
declare(strict_types=1);

namespace App\ParamConverter\Controller\Api\Api\Entity\Car\CommonController;

use App\Exception\Controller\Api\ApiException;
use App\Handler\Controller\Api\Api\Entity\Car\CommonController\ForGetLastCarsHandler\QueryFiltersCollector;
use App\Util\Common\TypeConvertingResolver;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

final class GetLastCarsParamConverter implements ParamConverterInterface
{
    private TypeConvertingResolver $typeConvertingResolver;
    
    public function __construct()
    {
        $this->typeConvertingResolver = new TypeConvertingResolver();
    }
    
    public function supports(ParamConverter $configuration): bool 
    {
        return $configuration->getClass() == QueryFiltersCollector::class;
    }
    
    public function apply(Request $request, ParamConverter $configuration): void 
    {
        $queryFiltersCollector = $this->checkParametersAndConfigureFiltersCollector($request, new QueryFiltersCollector());
        
        $request->attributes->set($configuration->getName(), $queryFiltersCollector);
    }

    private function checkParametersAndConfigureFiltersCollector(
        Request $request, QueryFiltersCollector $queryFiltersCollector
    ): QueryFiltersCollector
    {
        if (!is_null($limit = $request->query->get('limit', null)) 
            && (!is_string($limit) || !$this->typeConvertingResolver->canConvertToInteger($limit) || (int)$limit <= 0)) {
            throw new ApiException('Bad parameters', 400, null);
        }
        $queryFiltersCollector->setLimit(!is_null($limit) ? (int)$limit : 20);

        return $queryFiltersCollector;
    }
}