<?php

namespace App\Services;

use App\Models\Address;

class AddressService
{
    public function __construct(public Address $address)
    {
    }
    public function setAddressByAdress(Address $address)
    {
        $this->address = $address;
        return $this;
    }
    public function all()
    {
        return $this->address::all();
    }

    public function getById(int $id)
    {
        return $this->address::find($id);
    }

    public function create(array $data)
    {
        return $this->address::create($data);
    }

    public function update(array $data)
    {
        return $this->address->update($data);
    }

    public function delete(int $id)
    {
        return $this->address::query()->where('id', $id)->delete();
    }
}
