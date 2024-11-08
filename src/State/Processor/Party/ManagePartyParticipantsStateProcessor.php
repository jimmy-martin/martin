<?php

namespace App\State\Processor\Party;

use ApiPlatform\Metadata\HttpOperation;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\Party\PartyDtoFull;
use App\Dto\User\ManageParticipantsDto;
use App\Entity\Party;
use App\Entity\User;
use App\State\AbstractStateX;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ManagePartyParticipantsStateProcessor extends AbstractStateX implements ProcessorInterface
{
    /**
     * @param ManageParticipantsDto $data
     * @param HttpOperation         $operation
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        return match ($operation->getMethod()) {
            HttpOperation::METHOD_POST => $this->processPost($data, $operation, $uriVariables, $context),
            default => throw new \RuntimeException(\sprintf('Unsupported method "%s"', $operation->getMethod())),
        };
    }

    /**
     * @param User[] $participants
     */
    public function add(Party $party, array $participants): void
    {
        $currentParticipantsCount = $party->getParticipants()->count();
        $newParticipantsCount = $currentParticipantsCount + \count($participants);

        if ($newParticipantsCount > $party->getMaxParticipants()) {
            throw new BadRequestHttpException(
                \sprintf(
                    'Number of participants exceeds the maximum allowed for this party (%d).',
                    $party->getMaxParticipants()
                )
            );
        }

        foreach ($participants as $participant) {
            $party->addParticipant($participant);
        }
    }

    /**
     * @param User[] $participants
     */
    public function remove(Party $party, array $participants): void
    {
        foreach ($participants as $participant) {
            $party->removeParticipant($participant);
        }
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    private function processPost(ManageParticipantsDto $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        $party = $this->entityManager->find(Party::class, $uriVariables['id']);

        if (null === $party) {
            throw new NotFoundHttpException(\sprintf('Party with id "%s" not found', $uriVariables['id']));
        }

        $participants = $this->entityManager->getRepository(User::class)->findBy(['id' => [...$data->ids]]);

        match ($operation->getName()) {
            'add_participants' => $this->add($party, $participants),
            'remove_participants' => $this->remove($party, $participants),
            default => throw new \RuntimeException(\sprintf('Unsupported operation "%s"', $operation->getName())),
        };

        $this->entityManager->flush();

        return $this->mapper->map($party, PartyDtoFull::class);
    }
}
