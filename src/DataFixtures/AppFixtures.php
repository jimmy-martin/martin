<?php

namespace App\DataFixtures;

use App\Factory\InterestFactory;
use App\Factory\PartyFactory;
use App\Factory\PartyTypeFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public static array $partyTypes = [
        ['Jeux de sociétés', 'Des jeux de sociétés pour tous les goûts'],
        ['Jeux vidéos', 'Des jeux vidéos pour tous les goûts'],
        ['Soirée classique', 'Une soirée classique'],
    ];

    public static array $interests = [
        'Jeux de sociétés',
        'Jeux vidéos',
        'Boîtes de nuit',
        'Soirées alcoolisées',
    ];

    public function __construct(
        private readonly int $maxUsersToCreate = 10,
        private readonly int $maxPartiesToCreate = 20,
    ) {}

    public function load(ObjectManager $manager): void
    {
        PartyTypeFactory::createMany(\count(self::$partyTypes), static function ($i) {
            --$i;

            return [
                'name' => self::$partyTypes[$i][0],
                'description' => self::$partyTypes[$i][1],
            ];
        });

        InterestFactory::createMany(\count(self::$interests), static function ($i) {
            --$i;

            return [
                'name' => self::$interests[$i],
            ];
        });

        UserFactory::createMany($this->maxUsersToCreate);
        PartyFactory::createMany($this->maxPartiesToCreate);
    }
}
