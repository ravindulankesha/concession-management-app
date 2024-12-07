<?php

namespace App\Http\Controllers;

use App\Jobs\SendOrderToKitchen;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        //passed in repsoitory instance is being stored in the class property $orderRepository
        $this->orderRepository = $orderRepository;
    }

    //calls the getFinished function in the repo
    //getFinished returns finished orders and parses it to the kitchen view as an associative array
    public function index()
    {
        $orders = $this->orderRepository->getFinished();
        return view('kitchen', compact('orders'));
    }

    // The id of a single order is parsed in from the view finally to the find method in repo
    // An order with its stored details is returned and stored in $order
    public function sendToKitchen($id)
    {
        $order = $this->orderRepository->find($id);
        // if order status isn't pending the order is already being processed hence the index function is called
        if ($order->status != 'Pending') {
            return redirect()->route('orders.index')->with('error', 'Order is already processed.');
        }

        //parses the order id and the status field to the repo's update function
        $this->orderRepository->update($id, ['status' => 'In Progress']);

        return redirect()->route('orders.index');
    }

    // The id of a single order is parsed in from the view finally to the update function in repo along with the status
    public function updateStatus($id)
    {
        $this->orderRepository->update($id, ['status' => 'Completed']);
        // redirects to the index function
        return redirect()->route('kitchen.index');
    }
}
