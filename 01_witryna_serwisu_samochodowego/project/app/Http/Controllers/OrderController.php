<?php

namespace App\Http\Controllers;

use App\Helpers\HasEnsure;
use App\Helpers\ManageImages;
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
    use HasEnsure;
    use ManageImages;

    public function index(): View | RedirectResponse
    {
        $userID = Auth::id();
        $userType = User::where('ID', $userID)->value('type');
        if ($userType == 2) {
            $requests = RepairRequest::whereHas('orders', function ($query) {
                $query->where('orders.employeeID', '=', Auth::id());
            })->orderBy('id', 'desc')->get();
            return view('orders.index')->with('requests', $requests);
        }
        return redirect()->route('requests.index');
    }
    public function show(Order $order): RedirectResponse | View
    {
        $request = RepairRequest::find($order->requestID);

        if (Auth::id() == $order->employeeID) {
            return view('requests.show_employee')->with('orderInfo', $order)->with('request', $request);
        } else {
            return redirect()->route('orders.index');
        }
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $this->validate_order($this, $request);
        $this->updateAndSave($order, $request);

        return redirect()->route('orders.show', $order);
    }

    private function updateAndSave(Order $order, Request $request): void
    {
        if (is_numeric($request->requestID)) {
            RepairRequestController::update_status((int)$request->requestID, 1);
            $order->requestID = (int)$request->requestID;
        }
        if (is_numeric($request->employeeID)) {
            $order->employeeID = (int)$request->employeeID;
        }
        $order->startDatetime = $this->ensureIsString($request->startDatetime);
        if (is_numeric($request->estDuration)) {
            $order->estDuration = (int)$request->estDuration;
        }
        $images = ($request->existingImages != "") ? $request->existingImages : "";
        if ($request->file('image') != null) {
            $images = $this->storeImages($request, $this->ensureIsString($images));
        }
        $order->images = $this->ensureIsStringOrNull($images);
        if (is_numeric($request->cost)) {
            $order->cost = (float)$request->cost;
        }
        $order->save();
    }
    public function store(Request $request): RedirectResponse
    {
        $this->validate_order($this, $request);
        $order = new Order();
        $this->updateAndSave($order, $request);

        return redirect()->route('orders.show', $order);
    }
    public function edit(Order $order): View | RedirectResponse
    {
        $request = RepairRequest::find($order->requestID);
        $userID = Auth::id();
        $userType = User::where('ID', $userID)->value('type');
        if (isset($request->status)) {
            if ($userType == 2 && $order->employeeID == $userID && $request->status == 1) {
                return view('orders.edit')->with('order', $order)->with('request', $request);
            }
        }
        return redirect()->route('orders.index');
    }

    private function validate_order(OrderController $oc, Request $request): void
    {
        $oc->validate($request, [
            'requestID' => 'exists:repair_requests,id',
            'employeeID' => 'exists:users,id',
            'startDatetime' => 'required',
            'estDuration' => 'required|numeric',
            'cost' => 'required|numeric'
        ]);
    }
}
