<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function __construct(public User $user)
    {
    }
    public function setUserByUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function all()
    {
        return $this->user::all();
    }

    public function getById(int $id)
    {
        return $this->user::with('address')->find($id);
    }

    public function create(array $data)
    {
        return $this->user::create($data);
    }

    public function update(array $data)
    {
        return $this->user->update($data);
    }

    public function delete(int $id)
    {
        return $this->user::query()->where('id', $id)->delete();
    }
}
