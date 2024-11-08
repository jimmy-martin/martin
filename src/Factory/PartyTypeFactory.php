<?php

namespace App\Factory;

use App\Entity\PartyType;
use App\Repository\PartyTypeRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<PartyType>
 *
 * @method        PartyType|Proxy                              create(array|callable $attributes = [])
 * @method static PartyType|Proxy                              createOne(array $attributes = [])
 * @method static PartyType|Proxy                              find(object|array|mixed $criteria)
 * @method static PartyType|Proxy                              findOrCreate(array $attributes)
 * @method static PartyType|Proxy                              first(string $sortedField = 'id')
 * @method static PartyType|Proxy                              last(string $sortedField = 'id')
 * @method static PartyType|Proxy                              random(array $attributes = [])
 * @method static PartyType|Proxy                              randomOrCreate(array $attributes = [])
 * @method static PartyTypeRepository|ProxyRepositoryDecorator repository()
 * @method static PartyType[]|Proxy[]                          all()
 * @method static PartyType[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static PartyType[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static PartyType[]|Proxy[]                          findBy(array $attributes)
 * @method static PartyType[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static PartyType[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method static ProxyRepositoryDecorator<PartyType, EntityRepository> repository()
 */
final class PartyTypeFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct() {}

    public static function class(): string
    {
        return PartyType::class;
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
        // ->afterInstantiate(function(PartyType $partyType): void {})
    }
}
