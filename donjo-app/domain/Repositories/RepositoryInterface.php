<?php

declare(strict_types=1);

namespace Donjo\Domain\Repositories;

/**
 * Generic repository contract for persisting and retrieving domain entities.
 *
 * Implementations act as a collection-like boundary between the domain layer
 * and any persistence concern (database, cache, remote API, etc.) and must
 * NOT depend on framework-specific code.
 *
 * @template TEntity of object The entity type managed by the repository.
 */
interface RepositoryInterface
{
    /**
     * Find a single entity by its unique identifier.
     *
     * @param mixed $id The entity identifier.
     * @return object|null The entity or null.
     */
    public function find($id);

    /**
     * Return every entity managed by this repository.
     *
     * @return object[] List of entities.
     */
    public function findAll(): array;

    /**
     * Persist an entity.
     *
     * @param object $entity The entity to save.
     * @return object The saved entity.
     */
    public function save($entity);

    /**
     * Remove an entity by its identifier.
     *
     * @param mixed $id The entity identifier.
     * @return bool True on success.
     */
    public function delete($id): bool;
}