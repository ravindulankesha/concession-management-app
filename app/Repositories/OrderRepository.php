<?php
namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    //returns a collection of all orders with its related concessions
    public function getAll()
    {
        return Order::with('concessions')->get();
    }

    //returns a collection of finished orders with its related concessions
    public function getFinished()
    {
        return Order::with('concessions')->where('status','!=','Pending')->get();
    }

    //returns the model instance based on id or fails if not found
    public function find($id)
    {
        return Order::with('concessions')->findOrFail($id);
    }

    public function create(array $data)
    {
        //creates a db record in the order table
        $order = Order::create($data);
        //calls the relationship and create records in the concession_order pivot table
        $order->concessions()->attach($data['concessions']);
        return $order;
    }

    //takes the id and updates the record and returns the updated order
    public function update($id, array $data)
    {
        $order = $this->find($id);
        $order->update($data);
        if (isset($data['concessions'])) {
            $order->concessions()->sync($data['concessions']);
        }
        return $order;
    }

    //takes the id and deletes the specific record
    public function delete($id)
    {
        $order = $this->find($id);
        return $order->delete();
    }
}
