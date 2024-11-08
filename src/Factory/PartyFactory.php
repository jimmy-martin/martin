<?php

namespace App\Factory;

use App\Entity\Party;
use App\Repository\PartyRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Party>
 *
 * @method        Party|Proxy                              create(array|callable $attributes = [])
 * @method static Party|Proxy                              createOne(array $attributes = [])
 * @method static Party|Proxy                              find(object|array|mixed $criteria)
 * @method static Party|Proxy                              findOrCreate(array $attributes)
 * @method static Party|Proxy                              first(string $sortedField = 'id')
 * @method static Party|Proxy                              last(string $sortedField = 'id')
 * @method static Party|Proxy                              random(array $attributes = [])
 * @method static Party|Proxy                              randomOrCreate(array $attributes = [])
 * @method static PartyRepository|ProxyRepositoryDecorator repository()
 * @method static Party[]|Proxy[]                          all()
 * @method static Party[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static Party[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static Party[]|Proxy[]                          findBy(array $attributes)
 * @method static Party[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static Party[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method static ProxyRepositoryDecorator<Party, EntityRepository> repository()
 */
final class PartyFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct() {}

    public static function class(): string
    {
        return Party::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        $createdAt = new \DateTime();
        $isFree = self::faker()->boolean();

        return [
            'createdAt' => $createdAt,
            'createdBy' => UserFactory::random(),
            'date' => \DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-1 year', '+1 year')),
            'isFree' => $isFree,
            'maxParticipants' => self::faker()->numberBetween(2, 25),
            'name' => self::faker()->text(25),
            'price' => $isFree ? null : self::faker()->numberBetween(5, 50),
            'updatedAt' => $createdAt,
            'type' => PartyTypeFactory::random(),
            'address' => AddressFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this;
        // ->afterInstantiate(function(Party $party): void {})
    }
}
