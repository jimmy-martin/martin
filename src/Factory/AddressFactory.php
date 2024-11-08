<?php

namespace App\Factory;

use App\Entity\Address;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Address>
 *
 * @method        Address|Proxy                              create(array|callable $attributes = [])
 * @method static Address|Proxy                              createOne(array $attributes = [])
 * @method static Address|Proxy                              find(object|array|mixed $criteria)
 * @method static Address|Proxy                              findOrCreate(array $attributes)
 * @method static Address|Proxy                              first(string $sortedField = 'id')
 * @method static Address|Proxy                              last(string $sortedField = 'id')
 * @method static Address|Proxy                              random(array $attributes = [])
 * @method static Address|Proxy                              randomOrCreate(array $attributes = [])
 * @method static AddressRepository|ProxyRepositoryDecorator repository()
 * @method static Address[]|Proxy[]                          all()
 * @method static Address[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static Address[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static Address[]|Proxy[]                          findBy(array $attributes)
 * @method static Address[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static Address[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method static ProxyRepositoryDecorator<Address, EntityRepository> repository()
 */
final class AddressFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct() {}

    public static function class(): string
    {
        return Address::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        $department = self::faker()->department();

        return [
            'city' => current($department),
            'country' => 'France',
            'postalCode' => key($department),
            'region' => self::faker()->region(),
            'street' => self::faker()->streetAddress(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this;
        // ->afterInstantiate(function(Address $address): void {})
    }
}
