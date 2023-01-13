<?php

namespace App\Http\Controllers;

use App\Helpers\HasEnsure;
use App\Helpers\ManageImages;
use App\Models\Order;
use App\Models\RepairRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    use HasEnsure;
    use ManageImages;

    public function index(): View | RedirectResponse
    {
        $userID = Auth::id();
        $userType = User::where('ID', $userID)->value('type');
        $users = User::orderBy('id', 'desc')->get();
        if ($userType == 3) {
            return view('employees.index')->with('users', $users);
        }
        return view('welcome');
    }


    public function show(int $id): RedirectResponse | View
    {
        $user = User::find($id);
        return view('employees.show')->with('user', $user);
    }

}
