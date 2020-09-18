<?php
declare(strict_types=1);

namespace Config\Packages\messenger;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $containerConfigurator) {
    $containerConfigurator->extension('framework', []);
};