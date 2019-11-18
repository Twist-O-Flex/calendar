<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Domain\Repository\UserRepository;
use App\Infrastructure\Api\Geo\CityRepository;
use Psr\Cache\CacheItemPoolInterface;

return function (ContainerConfigurator $configurator) {
    // default configuration for services in *this* file
    $services = $configurator->services()
        ->defaults()
        ->autowire()      // Automatically injects dependencies in your services.
        ->autoconfigure() // Automatically registers your services as commands, event subscribers, etc.
    ;

    $services
        ->alias("test." . UserRepository::class, UserRepository::class)
        ->alias("test" . CityRepository::class, CityRepository::class)
        ->alias("test." . CacheItemPoolInterface::class, CacheItemPoolInterface::class)
    ;
};
