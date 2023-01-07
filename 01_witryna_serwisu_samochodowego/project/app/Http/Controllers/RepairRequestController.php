<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\RepairRequest;
use App\Models\User;
use Illuminate\Http\Request;

use App\Helpers\HasEnsure;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RepairRequestController extends Controller
{
    use HasEnsure;

    public function index(): View
    {
        $userID = Auth::id();
        $userType = User::where('ID', $userID)->value('type');
        switch($userType) {
            case 1:
                $requests = RepairRequest::where('clientID', $userID)->orderBy('id', 'desc')->get();
                return view('requests.index_user')->with('requests', $requests);
            case 2:
                $requests = RepairRequest::where('status', 0)->orderBy('id', 'desc')->get();
                return view('requests.index_employee')->with('requests', $requests);
            case 3:
                $requests = RepairRequest::orderBy('id', 'desc')->get();
                return view('requests.index_admin')->with('requests', $requests);
        }
        return view('welcome');
    }
    public function show(RepairRequest $request): View | RedirectResponse
    {
        $userID = Auth::id();
        $userType = User::where('ID', $userID)->value('type');
        $orderInfo = Order::where('requestID', $request->id)->first();

        switch($userType) {
            case 1:
                if ($userID == $request->clientID) {
                    return view('requests.show_user')->with('request', $request)->with('orderInfo', $orderInfo);
                } else {
                    return redirect()->route('requests.index');
                }
                // no break
            case 2:
                if ($request->status == 0) {
                    return view('requests.show_employee')->with('request', $request);
                } else {
                    if ($userID == $orderInfo->employeeID) {
                        return view('requests.show_employee')->with('request', $request)->with('orderInfo', $orderInfo);
                    } else {
                        return redirect()->route('requests.index');
                    }
                }
                // no break
            case 3:
                return view('requests.show_admin')->with('request', $request)->with('orderInfo', $orderInfo);
        }
        return view('welcome');
    }

    // Function to change status of selected request
    public static function update_status(int $id, int $new_status): void
    {
        $request = RepairRequest::find($id);
        $request->status = $new_status;
        $request->save();
    }

    // Employee accepts request -> become an order
    public function accept_request(RepairRequest $request): View
    {
        return view('requests.accept')->with('request', $request);
    }

    // User accepts new date - change status to 0 and redirect/view
    public function accept(RepairRequest $request): View
    {
        return view('welcome');
    }

    // Employee responds with new date - new view with form
    public function respond(RepairRequest $request): View
    {
        return view('welcome');
    }

    // Employee or user rejects request - simple function with redirect or view
    public function reject(RepairRequest $request): View
    {
        return view('welcome');
    }

    // User creates new request - return view
    public function create(RepairRequest $request): View
    {
        return view('welcome');
    }
}
