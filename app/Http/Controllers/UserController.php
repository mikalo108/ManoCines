<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class UserController extends Controller
{
    private const PAGINATE_SIZE = 5;

    public function index(Request $request)
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $query = User::query();

        if ($request->filled('userId')) {
            $query->where('id', $request->userId);
        }

        if ($request->filled('username')) {
            $query->where('name', 'like', '%' . $request->username . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('role')) {
            $query->where('role', 'like', '%' . $request->role . '%');
        }

        $users = $query->orderBy('id', 'desc')->paginate(self::PAGINATE_SIZE);
        return Inertia::render('User/Index', [
            'users' => $users,
            'langTable' => fn () => Lang::get('tableUsers'),
            'fieldsCanFilter' => [
                ['key' => 'userId', 'field' => $request->userId],
                ['key' => 'username', 'field' => $request->username],
                ['key' => 'email', 'field' => $request->email],
                ['key' => 'role', 'field' => $request->role],
            ],
        ]);
    }

    public function create()
    {
        app()->setLocale(session('locale', app()->getLocale()));    

        return Inertia::render('User/Form', [
         'dataControl' => [
                ['key' => 'name', 'field' => '', 'type' => 'text', 'posibilities' => ''],
                ['key' => 'email', 'field' => '', 'type' => 'email', 'posibilities' => ''],
                ['key' => 'password', 'field' => '', 'type' => 'password', 'posibilities' => ''],
                ['key' => 'role', 'field' => '', 'type' => 'select', 'posibilities' => ['Admin', 'Client']],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|max:255',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role ?? 'Client';
        $user->save();

        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        app()->setLocale(session('locale', app()->getLocale()));    
        $user = User::findOrFail($id);

        return Inertia::render('User/Form', [
         'user' => $user,
         'dataControl' => [
                ['key' => 'name', 'field' => $user->name, 'type' => 'text', 'posibilities' => ''],
                ['key' => 'email', 'field' => $user->email, 'type' => 'email', 'posibilities' => ''],
                ['key' => 'password', 'field' => $user->password, 'type' => 'password', 'posibilities' => ''],
                ['key' => 'role', 'field' => $user->role, 'type' => 'select', 'posibilities' => ['Admin', 'Client']],
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'nullable|string|max:255',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->role = $request->role ?? $user->role;
        $user->save();

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->profile->delete();
        $user->delete();

        return redirect()->route('users.index');
        
    }
}
