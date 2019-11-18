<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Domain\Repository\CityRepositoryInterface;
use App\Infrastructure\Api\Geo\CityRepository;

return function (ContainerConfigurator $configurator) {
    // default configuration for services in *this* file
    $services = $configurator->services()
        ->defaults()
        ->autowire()      // Automatically injects dependencies in your services.
        ->autoconfigure() // Automatically registers your services as commands, event subscribers, etc.
    ;

    $services
        ->alias(CityRepositoryInterface::class, CityRepository::class)
    ;
};
