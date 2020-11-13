<?php


namespace App\Repositories;


use App\Models\User;

class UserRepository
{
    public function createUser(array $validated)
    {
        return User::create($validated);
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function findUserById($user_id)
    {
        return User::find($user_id);
    }

    public function getUserByPhoneNumber($phone_number)
    {
        return User::query()->where('phone_number', $phone_number)->first();
    }

    /**
     * @param $user
     */
    public function updateUser(User $user,$fields_array): void
    {
        $user->update($fields_array);
    }
}
