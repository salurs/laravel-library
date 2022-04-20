<?php

namespace App\Services;

use App\Models\Library;

class LibraryService
{
    public function __construct(public Library $library)
    {
    }
    public function setLibraryByLibrary(Library $library)
    {
        $this->library = $library;
        return $this;
    }
    public function all()
    {
        return $this->library::all();
    }

    public function getById(int $id)
    {
        return $this->library::find($id);
    }

    public function create(array $data)
    {
        return $this->library::create($data);
    }

    public function update(array $data)
    {
        return $this->library->update($data);
    }

    public function delete(int $id)
    {
        return $this->library::query()->where('id', $id)->delete();
    }
}
