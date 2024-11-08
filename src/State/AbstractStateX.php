<?php

namespace App\State;

use Doctrine\ORM\EntityManagerInterface;
use Rekalogika\Mapper\IterableMapperInterface;
use Rekalogika\Mapper\MapperInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractStateX
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected MapperInterface $mapper,
        protected IterableMapperInterface $iterableMapper,
    ) {}

    public function getRequest(array $context): ?Request
    {
        return $context['request'] ?? null;
    }
}
