<?php

namespace App\Factory;

use App\Entity\Interest;
use App\Repository\InterestRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Interest>
 *
 * @method        Interest|Proxy                              create(array|callable $attributes = [])
 * @method static Interest|Proxy                              createOne(array $attributes = [])
 * @method static Interest|Proxy                              find(object|array|mixed $criteria)
 * @method static Interest|Proxy                              findOrCreate(array $attributes)
 * @method static Interest|Proxy                              first(string $sortedField = 'id')
 * @method static Interest|Proxy                              last(string $sortedField = 'id')
 * @method static Interest|Proxy                              random(array $attributes = [])
 * @method static Interest|Proxy                              randomOrCreate(array $attributes = [])
 * @method static InterestRepository|ProxyRepositoryDecorator repository()
 * @method static Interest[]|Proxy[]                          all()
 * @method static Interest[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static Interest[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static Interest[]|Proxy[]                          findBy(array $attributes)
 * @method static Interest[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static Interest[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method static ProxyRepositoryDecorator<Interest, EntityRepository> repository()
 */
final class InterestFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct() {}

    public static function class(): string
    {
        return Interest::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this;
        // ->afterInstantiate(function(Interest $interest): void {})
    }
}
