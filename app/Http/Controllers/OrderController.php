<?php

namespace App\Http\Controllers;

use App\Jobs\SendOrderToKitchen;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\ConcessionRepositoryInterface;
use Carbon\Carbon;

class OrderController extends Controller
{
    protected $orderRepository;
    protected $concessionRepository;

    public function __construct(OrderRepositoryInterface $orderRepository, ConcessionRepositoryInterface $concessionRepository)
    {
         //passed in repsoitory instances are being stored in the class properties $orderRepository and $concessionRepository
        $this->orderRepository = $orderRepository;
        $this->concessionRepository = $concessionRepository;
    }

    //get all orders via the repo function and parse it to the view as an associative array
    public function index()
    {
        $orders = $this->orderRepository->getAll();
        return view('orders.index', compact('orders'));
    }

    //get all concessions from concessionRepo's getAll function and parse it to the order creating view as an associative array
    public function create()
    {
        $concessions = $this->concessionRepository->getAll();
        return view('orders.create', compact('concessions'));
    }

    //validating and parsing the validated data to the create function in orderRepo
    public function store(Request $request)
    {

        $request->validate([
            'concessions' => 'required|array',
            'concessions.*' => 'exists:concessions,id',
            'send_to_kitchen_time' => 'required|date|after:now',
        ]);

        $data = $request->all();

        $order = $this->orderRepository->create($data);

        //the queue is works and the handle method of the SendOrderToKitchen JOB is invoked
        SendOrderToKitchen::dispatch($order)->delay(now('Asia/Colombo')->addSeconds(abs(Carbon::parse($order->send_to_kitchen_time,'Asia/Colombo')->diffInSeconds(now('Asia/Colombo')))));
        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function destroy($id)
    {
        $this->orderRepository->delete($id);
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
