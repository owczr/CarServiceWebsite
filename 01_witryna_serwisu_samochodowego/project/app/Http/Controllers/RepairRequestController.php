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
use Illuminate\Support\Facades\Date;
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
                    if ($orderInfo && $userID == $orderInfo->employeeID) {
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
        if ($request) {
            $request->status = $new_status;
            $request->save();
        }
    }
    private static function save_new_date(int $id, string $new_date): void
    {
        $request = RepairRequest::find($id);
        if ($request) {
            $request->date = $new_date;
            $request->save();
        }
    }

    // Employee accepts request -> become an order
    public function accept_request(RepairRequest $request): View | RedirectResponse
    {
        $userID = Auth::id();
        $userType = User::where('ID', $userID)->value('type');
        if ($request->status == 0 && $userType == 2) {
            return view('requests.accept')->with('request', $request);
        }
        return redirect()->route('requests.index');
    }

    // User accepts new date - change status to 0 and redirect/view
    public function accept(RepairRequest $request): RedirectResponse
    {
        $requestID = $request->id;
        self::update_status($requestID, 0);
        return redirect()->route('requests.show', $request);
    }

    // Employee responds with new date - new view with form
    public function respond(RepairRequest $request): View | RedirectResponse
    {
        $userID = Auth::id();
        $userType = User::where('ID', $userID)->value('type');
        if ($request->status == 0 && $userType == 2) {
            return view('requests.respond')->with('request', $request);
        }
        return redirect()->route('requests.index');
    }

    public function send_respond(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'new_date' => 'date',
        ]);

        $requestID = $request->requestID;
        if (is_int($requestID)) {
            self::update_status($requestID, 2);
            self::save_new_date($requestID, $this->ensureIsString($request->new_date));
        }
        return redirect()->route('requests.index');
    }

    // Employee or user rejects request - simple function with redirect
    public function reject(RepairRequest $request): RedirectResponse
    {
        $userID = Auth::id();
        $userType = User::where('ID', $userID)->value('type');
        if (($userType == 1 && $request->clientID == $userID && $request->status == 2) || ($userType == 2 && $request->status == 0)) {
            self::update_status($request->id, 3);
        }
        return redirect()->route('requests.index');
    }

    // Employee finish order - change status to closed (4)
    public function finish(RepairRequest $request): RedirectResponse
    {
        $userID = Auth::id();
        $userType = User::where('ID', $userID)->value('type');
        if ($userType == 2 && $request->status == 1) {
            $employeeID = Order::where('requestID', $request->id)->value('employeeID');
            if ($employeeID == $userID) {
                self::update_status($request->id, 4);
                return redirect()->route('requests.show', $request);
            }
            return redirect()->route('orders.index');
        }
        return redirect()->route('requests.index');
    }
    // User creates new request - return view
    public function create(RepairRequest $request): View
    {
        return view('requests.create');
    }

    private function updateAndSave(RepairRequest $repairRequest, Request $request): void
    {
        $repairRequest->clientID = (int)Auth::id();
        $repairRequest->title = $this->ensureIsString($request->title);
        $repairRequest->model = $this->ensureIsString($request->model);
        $repairRequest->description = $this->ensureIsString($request->description);
        $repairRequest->date = $this->ensureIsString($request->date);
        $repairRequest->status = 0;
        if ($request->file('image') != null) {
            $img = "";
            if (is_array($request->file('image'))) {
                foreach ($request->file('image') as $key => $file) {
                    $filePath = $file->store('images');
                    if ($filePath) {
                        $img = $img.$filePath.'|';
                    }
                }
            }
            $repairRequest->images = $img;
        }

        $repairRequest->save();
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'title' => 'required',
            'model' => 'required',
            'description' => 'required',
            'date' => 'required'
        ]);

        $repairRequest = new RepairRequest();
        $this->updateAndSave($repairRequest, $request);

        return redirect()->route('requests.show', $repairRequest);
    }
}
