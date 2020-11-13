<?php


namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    /**
     * @var UserRepository
     */
    private $user_repository;

    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function createUser(array $validated)
    {
        return $this->user_repository->createUser($validated);
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function findUserById($user_id)
    {
        return $this->user_repository->findUserById($user_id);
    }

    public function getUserByPhoneNumber($phone_number)
    {
        return $this->user_repository->getUserByPhoneNumber($phone_number);
    }

    /**
     * @param $user
     */
    public function updateUser(User $user,$fields_array): void
    {
        $this->updateUser($user,$fields_array);
    }
}
