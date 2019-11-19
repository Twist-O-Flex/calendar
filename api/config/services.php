<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Application\DataTransformer\ClubInputDataTransformer;
use App\Domain\Repository\CityRepositoryInterface;
use App\Domain\Repository\ClubRepositoryInterface;
use App\Infrastructure\Api\Geo\CityRepository;
use App\Infrastructure\Api\Geo\CityRepositoryCache;
use App\Infrastructure\Repository\ClubRepositoryAdapter;

return function (ContainerConfigurator $configurator) {
    // default configuration for services in *this* file
    $services = $configurator->services()
        ->defaults()
            ->private()
            ->autowire()      // Automatically injects dependencies in your services.
            ->autoconfigure() // Automatically registers your services as commands, event subscribers, etc.
    ;

    $services
        ->load('App\\', '../src/*')
        ->exclude('../src/{DependencyInjection,Entity,Migrations,Tests,Kernel.php}')
    ;

    /*
     * Alias
     */
    $services
        ->alias(CityRepositoryInterface::class, CityRepositoryCache::class)
        ->alias(ClubRepositoryInterface::class, ClubRepositoryAdapter::class)
    ;

    /*
     * Decorator
     */
    $services
        ->set(CityRepositoryCache::class)
        ->decorate(CityRepository::class)
        ->bind(CityRepositoryInterface::class, ref(CityRepositoryCache::class . ".inner"))
    ;
};
