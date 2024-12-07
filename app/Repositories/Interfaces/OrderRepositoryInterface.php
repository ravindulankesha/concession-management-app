<?php
namespace App\Repositories\Interfaces;

interface OrderRepositoryInterface
{
    public function getAll();
    public function getFinished();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}