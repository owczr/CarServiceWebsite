<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\RepairRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View | RedirectResponse
    {
        $userID = Auth::id();
        $userType = User::where('ID', $userID)->value('type');
        if ($userType == 2) {
            $requests = RepairRequest::whereHas('orders', function ($query) {
                $query->where('orders.employeeID', '=', Auth::id());
            })->get();
            return view('orders.index')->with('requests', $requests);
        }
        return redirect()->route('requests.index');
    }
    public function show(Order $order): RedirectResponse | View
    {
        $request = $request = RepairRequest::find($order->requestID);
        $userID = Auth::id();

        if ($userID == $order->employeeID) {
            return view('requests.show_employee')->with('request', $request)->with('orderInfo', $order);
        } else {
            return redirect()->route('orders.index');
        }
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
