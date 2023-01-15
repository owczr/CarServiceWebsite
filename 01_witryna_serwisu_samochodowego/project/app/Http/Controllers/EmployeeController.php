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
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    use HasEnsure;
    use ManageImages;

    public function index(): View | RedirectResponse
    {
        if (!$this->check_admin()) {
            return redirect()->route('welcome');
        }
        $users = User::orderBy('id', 'desc')->get();
        return view('employees.index')->with('users', $users);
    }


    public function show(int $id): RedirectResponse | View
    {
        if (!$this->check_admin()) {
            return redirect()->route('welcome');
        }
        $this->check_admin();
        $user = User::find($id);
        return view('employees.show')->with('user', $user);
    }

    public function create(): View | RedirectResponse
    {
        if (!$this->check_admin()) {
            return redirect()->route('welcome');
        }
        return view('employees.create');
    }

    private function updateAndSave(User $user, Request $request): void
    {
        $user->name = $this->ensureIsString($request->name);
        $user->email = $this->ensureIsString($request->email);
        $user->phone = $this->ensureIsString($request->phone);
        $user->type = 2;
        if ($user-> name && $user->phone && strlen($user->name) > 3) {
            $password =  substr($user->name, 0, 2).
                substr($user->phone, 0, 4).substr($user->name, -2);
        } else {
            $password = 'pleasechangemeasap';
        }
        $user->password = Hash::make($password);
        $user->save();
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        $user = new User();
        $this->updateAndSave($user, $request);

        return redirect()->route('employees.show', $user);
    }

    private function check_admin(): Bool
    {
        $userID = Auth::id();
        $userType = User::where('ID', $userID)->value('type');
        if ($userType != 3) {
            return false;
        }
        return true;
    }
}
