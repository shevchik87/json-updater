<?php
declare(strict_types = 1);

namespace App\Component\User;

use App\Repository\UserRepository;

class UserManager
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var Generator
     */
    private $generator;

    /**
     * UserManager constructor.
     * @param UserRepository $repository
     * @param Generator $generator
     */
    public function __construct(UserRepository $repository, Generator $generator)
    {
        $this->repository = $repository;
        $this->generator = $generator;
    }

    public function getNewToken(): string
    {
        return $this->generator->getNewToken();
    }

    /**
     * @param string $login
     * @return bool
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function userIsExist(string $login): bool
    {
        return (bool) $this->repository->findByUserName($login);
    }

    /**
     * @param NewTokenDto $dto
     */
    public function saveNewToken(NewTokenDto $dto)
    {
        $this->repository->updateToken($dto);
    }

}
