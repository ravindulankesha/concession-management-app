<?php
namespace App\Repositories;

use App\Models\Concession;
use App\Repositories\Interfaces\ConcessionRepositoryInterface;

class ConcessionRepository implements ConcessionRepositoryInterface
{
    //returns a collection of all concessions
    public function getAll()
    {
        return Concession::all();
    }

    //returns the model instance based on id or fails if not found
    public function find($id)
    {
        return Concession::findOrFail($id);
    }

    //creates a db record in the concession table
    public function create(array $data)
    {
        return Concession::create($data);
    }

    //finds and updates a single record based on id
    public function update($id, array $data)
    {
        $concession = $this->find($id);
        $concession->update($data);
        return $concession;
    }

    //finds and deletes a single record based on id
    public function delete($id)
    {
        $concession = $this->find($id);
        return $concession->delete();
    }
}
