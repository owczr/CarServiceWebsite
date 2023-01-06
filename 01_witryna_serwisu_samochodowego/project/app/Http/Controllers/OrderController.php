<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\RepairRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('dashboard');
    }
    public function show(Order $order): RedirectResponse | View
    {
        $request = $request = RepairRequest::find($order->requestID);
        return view('requests.show_employee')->with('request', $request)->with('orderInfo', $order);
    }

    private function updateAndSave(Order $order, Request $request): void
    {
        RepairRequestController::update_status($request->requestID, 1);
        $order->requestID = $request->requestID;
        $order->employeeID = $request->employeeID;
        $order->startDatetime = $request->startDatetime;
        $order->estDuration = $request->estDuration;
        $order->cost = $request->cost;
        $order->save();
    }
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'requestID' => 'exists:repair_requests,id',
            'employeeID' => 'exists:users,id',
            'startDatetime' => 'required',
            'estDuration' => 'required|numeric',
            'cost' => 'required|numeric'
        ]);

        $order = new Order();
        $this->updateAndSave($order, $request);

        return redirect()->route('orders.show', $order);
    }
}
