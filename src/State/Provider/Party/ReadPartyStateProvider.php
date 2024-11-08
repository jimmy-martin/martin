<?php

namespace App\State\Provider\Party;

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\Party\PartyDtoFull;
use App\Dto\Party\PartyDtoLight;
use App\Entity\Party;
use App\State\AbstractStateX;

class ReadPartyStateProvider extends AbstractStateX implements ProviderInterface
{
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): null|array|object
    {
        if ($operation instanceof GetCollection) {
            return $this->processCollection($operation, $uriVariables, $context);
        }

        return $this->processSingle($operation, $uriVariables, $context);
    }

    /**
     * @return PartyDtoLight[]
     */
    public function processCollection(Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        $request = $this->getRequest($context);
        $page = $request->query->getInt('page', 1);

        if ('search_parties' === $operation->getName()) {
            $city = $request->query->get('city');
            $type = $request->query->get('type');
            $maxParticipants = $request->query->get('maxParticipants');
            $isFree = $request->query->get('isFree');
            $date = $request->query->get('date');

            $parties = $this->entityManager
                ->getRepository(Party::class)
                ->search(
                    page: $page,
                    city: $city,
                    type: $type,
                    maxParticipants: $maxParticipants,
                    isFree: $isFree,
                    date: $date
                )
            ;

            return $this->iterableMapper->mapIterable(
                $parties,
                PartyDtoLight::class
            );
        }

        return $this->iterableMapper->mapIterable(
            $this->entityManager->getRepository(Party::class)->findAllOptimized($page),
            PartyDtoLight::class
        );
    }

    public function processSingle(Operation $operation, array $uriVariables = [], array $context = []): ?PartyDtoFull
    {
        $id = $uriVariables['id'] ?? null;
        $party = $this->entityManager->getRepository(Party::class)->findOptimized($id);

        if (null === $party) {
            return null;
        }

        return $this->mapper->map(
            $party,
            PartyDtoFull::class
        );
    }
}
