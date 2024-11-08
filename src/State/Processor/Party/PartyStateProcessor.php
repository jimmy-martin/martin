<?php

namespace App\State\Processor\Party;

use ApiPlatform\Metadata\HttpOperation;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\Party\CreatePartyDto;
use App\Dto\Party\PartyDtoFull;
use App\Dto\Party\UpdatePartyDto;
use App\Entity\Address;
use App\Entity\Party;
use App\Entity\PartyType;
use App\Entity\User;
use App\State\AbstractStateX;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PartyStateProcessor extends AbstractStateX implements ProcessorInterface
{
    /**
     * @param HttpOperation $operation
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        return match ($operation->getMethod()) {
            HttpOperation::METHOD_POST => $this->processPost($data, $operation, $uriVariables, $context),
            HttpOperation::METHOD_PUT => $this->processPut($data, $operation, $uriVariables, $context),
            default => throw new \RuntimeException(\sprintf('Unsupported method "%s"', $operation->getMethod())),
        };
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    private function processPost(CreatePartyDto $data, Operation $operation, array $uriVariables = [], array $context = []): PartyDtoFull
    {
        $party = $this->mapper->map($data, Party::class);

        $party
            ->setCreatedBy($this->entityManager->find(User::class, $data->createdById))
            ->setType($this->entityManager->find(PartyType::class, $data->typeId))
            ->setUpdatedAt(new \DateTime())
        ;

        $this->entityManager->persist($party);
        $this->entityManager->flush();
        $this->entityManager->refresh($party);

        return $this->mapper->map($party, PartyDtoFull::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    private function processPut(UpdatePartyDto $data, Operation $operation, array $uriVariables = [], array $context = []): PartyDtoFull
    {
        $id = $uriVariables['id'];
        $party = $this->entityManager->find(Party::class, $id);

        if (null === $party) {
            throw new NotFoundHttpException(\sprintf('Party with id "%s" not found', $id));
        }

        $oldAddress = $this->entityManager->getRepository(Address::class)->find($data->address->id);
        $newAddress = $oldAddress
            ->setCity($data->address->city)
            ->setStreet($data->address->street)
            ->setPostalCode($data->address->postalCode)
            ->setRegion($data->address->region)
            ->setCountry($data->address->country)
        ;

        $party
            ->setName($data->name)
            ->setDate($data->date)
            ->setMaxParticipants($data->maxParticipants)
            ->setIsFree($data->isFree)
            ->setPrice($data->price)
            ->setType($this->entityManager->find(PartyType::class, $data->typeId))
            ->setAddress($newAddress)
            ->setUpdatedAt(new \DateTime())
        ;

        $this->entityManager->flush();

        return $this->mapper->map($party, PartyDtoFull::class);
    }
}
