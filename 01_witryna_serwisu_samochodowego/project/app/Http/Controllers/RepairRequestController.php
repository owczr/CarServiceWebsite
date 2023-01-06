<?php

namespace App\Http\Controllers;

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
        $books = RepairRequest::all();
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
}
