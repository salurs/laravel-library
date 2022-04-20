<?php

namespace App\Services;

use App\Models\Library;
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

    public function all($request)
    {
        $query = $this->user::query();
        if (isset($request['name'])){
            $query->where('normalized_name', 'LIKE', "%{$request['name']}%");
        }
        if (isset($request['orderBy'])){
            $query->orderBy('normalized_name', $request['orderBy']);
        }
        return $query->get();
    }

    public function getById(int $id)
    {
        return $this->user::with('address')->with('library')->find($id);
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

    public function assignLibrary(array $data)
    {
        $user = $this->user::with('library')->whereId($data['user_id'])->first();
        $library = Library::with('user')->whereId($data['library_id'])->first();
        if ($user->library()->count() >= 3)
            return ['status' => false,'message' => 'You can be a member of up to 3 libraries.'];
        if ($library->user()->count() >= 10)
            return ['status' => false,'message' => 'A library can have up to 10 members.'];

        $user->library()->attach($data['library_id']);
        return ['status' => true,'message' => 'Library has assigned.'];

    }
}
