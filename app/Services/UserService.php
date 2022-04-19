<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

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
        $data['normalized_name'] = $this->normalizedName($data['name']);
        return $this->user::create($data);
    }

    public function update(array $data)
    {
        if (isset($data['name']))
            $data['normalized_name'] = $this->normalizedName($data['name']);
        return $this->user->update($data);
    }

    public function delete(int $id)
    {
        return $this->user::query()->where('id', $id)->delete();
    }

    public function normalizedName(string $name)
    {
        $lower = Str::lower($name);
        $clean = Str::slug($lower);
        return str_replace('-', ' ', $clean);
    }
}
